<div id="logoutModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <p class=" mb-4">Are you sure you want to log out of Fitty?</p>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn custom-outline me-3" data-bs-dismiss="modal">Cancel</button>
                    <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nutri-btn">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
