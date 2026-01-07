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

        <!-- LEFT: FLOWER ITEMS -->
        <div class="col-md-7">
            <h5 class="fw-bold mb-3" style="color:#8b4d6b;">Flower POS</h5>

            <div class="row g-3">

                <!-- Flower Item -->
                <div class="col-md-4">
                    <div class="card card-dashboard card-pink text-center p-3 pos-item"
                        onclick="addToCart('Rose Bouquet', 1200)">
                        <i class="bi bi-flower1 fs-1 mb-2"></i>
                        <h6>Rose Bouquet</h6>
                        <p class="fw-bold">₱1,200</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-dashboard card-purple text-center p-3 pos-item"
                        onclick="addToCart('Tulip Bundle', 950)">
                        <i class="bi bi-flower1 fs-1 mb-2"></i>
                        <h6>Tulip Bundle</h6>
                        <p class="fw-bold">₱950</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-dashboard card-yellow text-center p-3 pos-item"
                        onclick="addToCart('Sunflower Set', 850)">
                        <i class="bi bi-flower1 fs-1 mb-2"></i>
                        <h6>Sunflower Set</h6>
                        <p class="fw-bold">₱850</p>
                    </div>
                </div>

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

@endsection
