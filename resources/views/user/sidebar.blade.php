<div class="col-md-4">
            <div class="card">
                <div class="card-header">Welcome , {{ Auth::user()->name }}</div>

                <div class="card-body">
                    <img class="card-img-top" src="https://thumbs.dreamstime.com/b/businessman-icon-vector-male-avatar-profile-image-profile-businessman-icon-vector-male-avatar-profile-image-182095609.jpg" alt="avatar profile img">

                    <ul class="list-group list-group-flush">
                        <a href="{{ route('home') }}" class="text-muted"><li class="list-group-item"><i class="fa-solid fa-house"></i> Dashboard</li></a>
                        <a href="{{ route('wishlist') }}" class="text-muted"><li class="list-group-item"><i class="fa-regular fa-heart"></i> Wishlist</li></a>
                        <a href="{{ route('my.order') }}" class="text-muted"><li class="list-group-item"><i class="fa-solid fa-file-lines"></i>  My Order</li></a>

                        <a href="{{ route('profile.setting') }}" class="text-muted"><li class="list-group-item"><i class="fa-solid fa-gear"></i> Setting</li></a>

                        <a href="{{ route('open.ticket') }}" class="text-muted"><li class="list-group-item"><i class="fa-brands fa-telegram"></i> Open Ticket</li></a>
                        <a href="{{ route('customer.logout') }}" class="text-muted"><li class="list-group-item"><i class="fa-solid fa-right-from-bracket"></i> Logout</li></a>
                    </ul>
                   
                </div>
            </div>
        </div>