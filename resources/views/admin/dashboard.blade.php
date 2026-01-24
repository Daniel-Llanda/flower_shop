@extends('admin.layout')

@section('content')
    <div style="height: 50px;"></div>
    <div class="row g-3" id="posArea">
        

        <!-- LEFT: FLOWER ITEMS -->
        <div class="col-md-8">
            <div class="d-flex justify-content-between my-2 align-items-center">   
                <h5 class="fw-bold mb-3" style="color:#8b4d6b;">Flower POS</h5>
                <div>
                    <a href="{{ route('pos-items.edit') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Edit POS Item
                    </a>

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPosItemModal">
                        <i class="bi bi-plus-circle"></i> Add POS Item
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <select id="colorFilter" class="form-select mb-3" onchange="filterByColor()">
                        <option value="all">All Colors</option>

                        @php
                            $colorNames = [
                                'primary' => 'Blue',
                                'secondary' => 'Gray',
                                'success' => 'Green',
                                'danger' => 'Red',
                                'warning' => 'Yellow',
                                'info' => 'Cyan',
                                'dark' => 'Dark',
                            ];
                        @endphp

                        @foreach($colors as $color)
                            <option value="{{ $color }}">
                                {{ $colorNames[$color] ?? ucfirst($color) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <select id="occasionFilter" class="form-select mb-3" onchange="filterByOccasion()">
                        <option value="all">All Occasions</option>

                        @foreach($occasions as $occasion)
                            <option value="{{ $occasion }}">
                                {{ $occasion }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>




            <div class="row g-3">
                @php
                    $lightTextColors = ['primary', 'success', 'danger', 'dark', 'secondary'];
                @endphp

                @foreach($posItems as $item)
                    @php
                        $textColor = in_array($item->item_color, $lightTextColors) ? 'text-white' : 'text-dark';
                    @endphp

                    <div class="col-md-3 pos-item-wrapper" data-color="{{ $item->item_color }}"  data-occasion="{{ $item->item_occasion ?? '' }}">
                        <div class="card card-dashboard text-center p-3 pos-item 
                            bg-{{ $item->item_color }} {{ $textColor }}"
                            onclick="addToCart('{{ $item->item_name }}', {{ $item->item_price }})">

                            <i class="bi bi-flower1 fs-1 mb-2"></i>

                            <h6 class="mb-1">{{ $item->item_name }}</h6>
                            <h6 class="mb-1">{{ $item->item_type }}</h6>
                            <h6 class="mb-1">{{ $item->item_occasion }}</h6>

                            <p class="fw-bold mb-0">
                                ₱{{ number_format($item->item_price, 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>

        <!-- RIGHT: POS CART -->
        <div class="col-md-4">
            <h5 class="fw-bold mb-3" style="color:#8b4d6b;">Order List</h5>

            <div class="card card-dashboard p-3">
                <ul class="list-group mb-3" id="cartList">
                    <li class="list-group-item text-muted text-center">
                        No items yet
                    </li>
                </ul>

                <div class="d-flex justify-content-between fw-bold mb-3">
                    <span>Total</span>
                    <span>₱<span id="totalAmount">0</span></span>
                </div>

                <button class="btn btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                    Checkout
                </button>

                <button class="btn btn-outline-danger w-100" onclick="clearCart()">
                    Clear
                </button>
            </div>
        </div>
    </div>



<script>
    let cart = {};
    let total = 0;

     function filterByOccasion() {
        const selectedOccasion = document.getElementById('occasionFilter').value;
        const items = document.querySelectorAll('.pos-item-wrapper');

        items.forEach(item => {
            const itemOccasion = item.getAttribute('data-occasion');

            if (selectedOccasion === 'all' || itemOccasion === selectedOccasion) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }
    function filterByColor() {
        const selectedColor = document.getElementById('colorFilter').value;
        const items = document.querySelectorAll('.pos-item-wrapper');

        items.forEach(item => {
            const itemColor = item.getAttribute('data-color');

            if (selectedColor === 'all' || itemColor === selectedColor) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
    document.querySelector('[data-bs-target="#checkoutModal"]').addEventListener('click', function (e) {
        if (Object.keys(cart).length === 0) {
            alert('Cart is empty!');
            e.preventDefault();
        }
    });


    function addToCart(name, price) {
        if (!cart[name]) {
            cart[name] = {
                price: price,
                quantity: 1
            };
        } else {
            cart[name].quantity++;
        }

        renderCart();
    }

    function updateQuantity(name, change) {
        cart[name].quantity += change;

        if (cart[name].quantity <= 0) {
            delete cart[name];
        }

        renderCart();
    }

    function renderCart() {
        const cartList = document.getElementById('cartList');
        cartList.innerHTML = '';
        total = 0;

        const items = Object.keys(cart);

        if (items.length === 0) {
            cartList.innerHTML =
                `<li class="list-group-item text-muted text-center">No items yet</li>`;
            document.getElementById('totalAmount').innerText = 0;
            return;
        }

        items.forEach(name => {
            const item = cart[name];
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';

            li.innerHTML = `
                <div>
                    <strong>${name}</strong><br>
                    <small>₱${item.price} x ${item.quantity}</small>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold ms-2">₱${itemTotal}</span>
                    <button class="btn btn-sm btn-outline-secondary"
                        onclick="updateQuantity('${name}', -1)">−</button>

                    <span class="fw-bold">${item.quantity}</span>

                    <button class="btn btn-sm btn-outline-secondary"
                        onclick="updateQuantity('${name}', 1)">+</button>

                    
                </div>
            `;

            cartList.appendChild(li);
        });

        document.getElementById('totalAmount').innerText = total;
    }

    function clearCart() {
        cart = {};
        total = 0;
        renderCart();
    }
</script>


<div class="modal fade" id="addPosItemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-lg makes it larger -->
        <div class="modal-content">
            <form method="POST" action="{{ route('pos-items.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add POS Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Item Name</label>
                            <input type="text" name="item_name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Price (₱)</label>
                            <input type="number" step="0.01" name="item_price" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Item Type</label>
                            <select name="item_type" class="form-select" required>
                                <option value="">Select type</option>
                                <option value="bundle">Bundle</option>
                                <option value="per_stem">Per Stem</option>
                            </select>
                        </div>

                        <!-- NEW COLOR SELECT -->
                        <div class="col-md-6">
                            <label class="form-label">Button Color</label>
                            <select name="item_color" class="form-select" required>
                                <option class="text-primary" value="primary">Blue</option>
                                <option class="text-secondary" value="secondary">Gray</option>
                                <option class="text-success" value="success">Green</option>
                                <option class="text-danger" value="danger">Red</option>
                                <option class="text-warning" value="warning">Yellow</option>
                                <option class="text-info" value="info">Cyan</option>
                                <option class="text-dark" value="dark">Dark</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Occasion</label>

                            <input 
                                type="text" 
                                name="item_occasion" 
                                id="item_occasion"
                                class="form-control"
                                placeholder="e.g. Valentine's Day">

                            @if(isset($occasions) && $occasions->count())
                                <div class="mt-2 d-flex flex-wrap gap-2">
                                    @foreach($occasions as $occasion)
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary btn-sm"
                                            onclick="setOccasion('{{ addslashes($occasion) }}')">
                                            {{ $occasion }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>


                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success">Save Item</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="checkoutModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Receipt & Customer Information</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3">

                    <!-- RECEIPT -->
                    <div class="col-md-6">
                        <h6 class="fw-bold">Order Details</h6>
                        <ul class="list-group mb-3" id="receiptList"></ul>
                        <div class="fw-bold text-end">
                            Total: ₱<span id="receiptTotal">0</span>
                        </div>
                    </div>

                    <!-- CUSTOMER INFO -->
                    <div class="col-md-6">
                        <input type="hidden" name="total_amount" id="hiddenTotal">
                        <input type="hidden" name="cart" id="cartInput">

                        <div class="mb-2">
                            <label>Name</label>
                            <input name="customer_name" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Contact Number</label>
                            <input name="contact_number" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Address</label>
                            <textarea name="address" class="form-control"></textarea>
                        </div>

                        <div class="mb-2">
                            <label>Order Type</label>
                            <select name="order_type" class="form-select" onchange="toggleDelivery(this.value)">
                                <option value="pickup">Pick Up</option>
                                <option value="delivery">Delivery</option>
                            </select>
                        </div>

                        <div class="mb-2 d-none" id="deliveryTimeDiv">
                            <label>Delivery Time</label>
                            <input type="time" name="delivery_time" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>Mode of Payment</label>
                            <select name="payment_mode" class="form-select">
                                <option value="cash">Cash</option>
                                <option value="gcash">GCash</option>
                                <option value="card">Card</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label>Message</label>
                            <textarea name="message" class="form-control"></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success">Confirm Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function setOccasion(value) {
        document.getElementById('item_occasion').value = value;
    }
    function openReceipt() {
        const receiptList = document.getElementById('receiptList');
        receiptList.innerHTML = '';

        let cartData = [];
        let total = 0;

        Object.keys(cart).forEach(name => {
            const item = cart[name];
            const subtotal = item.price * item.quantity;
            total += subtotal;

            receiptList.innerHTML += `
                <li class="list-group-item d-flex justify-content-between">
                    <span>${name} x ${item.quantity}</span>
                    <span>₱${subtotal}</span>
                </li>
            `;

            cartData.push({
                name: name,
                price: item.price,
                quantity: item.quantity
            });
        });

        document.getElementById('receiptTotal').innerText = total;
        document.getElementById('hiddenTotal').value = total;
        document.getElementById('cartInput').value = JSON.stringify(cartData);
    }

    function toggleDelivery(type) {
        document.getElementById('deliveryTimeDiv')
            .classList.toggle('d-none', type !== 'delivery');
    }

    document.getElementById('checkoutModal').addEventListener('show.bs.modal', openReceipt);
</script>




@endsection
