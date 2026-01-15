@extends('admin.layout')

@section('content')
    <div style="height: 50px;"></div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card card-dashboard p-3 card-pink text-center">
                <i class="bi bi-people fs-1 mb-2"></i>
                <h5>Users</h5>
                <p class="fs-4">120</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-dashboard p-3 card-purple text-center">
                <i class="bi bi-basket fs-1 mb-2"></i>
                <h5>Orders</h5>
                <p class="fs-4">45</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-dashboard p-3 card-yellow text-center">
                <i class="bi bi-flower1 fs-1 mb-2"></i>
                <h5>Flowers</h5>
                <p class="fs-4">78</p>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-4">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPosItemModal">
            <i class="bi bi-plus-circle"></i> Add POS Item
        </button>



        <!-- LEFT: FLOWER ITEMS -->
        <div class="col-md-7">
            <h5 class="fw-bold mb-3" style="color:#8b4d6b;">Flower POS</h5>

            <div class="row g-3">

                @foreach($posItems as $item)
                    <div class="col-md-4">
                        <div class="card card-dashboard text-center p-3 pos-item"
                                onclick="addToCart('{{ $item->item_name }}', {{ $item->item_price }})">
                            <i class="bi bi-flower1 fs-1 mb-2"></i>
                            <h6>{{ $item->item_name }}</h6>
                            <p class="fw-bold">₱{{ number_format($item->item_price, 2) }}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        <!-- RIGHT: POS CART -->
        <div class="col-md-5">
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

                <button class="btn btn-success w-100 mb-2">
                    Checkout
                </button>
                <button class="btn btn-outline-danger w-100" onclick="clearCart()">
                    Clear
                </button>
            </div>
        </div>

    </div>
<script>
    let total = 0;

    function addToCart(name, price) {
        const cartList = document.getElementById('cartList');

        if (cartList.children[0].classList.contains('text-muted')) {
            cartList.innerHTML = '';
        }

        const item = document.createElement('li');
        item.className = 'list-group-item d-flex justify-content-between';
        item.innerHTML = `<span>${name}</span><span>₱${price}</span>`;
        cartList.appendChild(item);

        total += price;
        document.getElementById('totalAmount').innerText = total;
    }

    function clearCart() {
        document.getElementById('cartList').innerHTML =
            `<li class="list-group-item text-muted text-center">No items yet</li>`;
        total = 0;
        document.getElementById('totalAmount').innerText = total;
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

                        <div class="col-md-12">
                            <label class="form-label">Item Type</label>
                            <select name="item_type" class="form-select" required>
                                <option value="">Select type</option>
                                <option value="bundle">Bundle</option>
                                <option value="per_stem">Per Stem</option>
                            </select>
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



@endsection
