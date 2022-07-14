<div class="global-container">
    <div class="card login-form">
        <div class="card-body">
            <h3 class="card-title text-center">Ubah Password</h3>
            <div class="card-text">

                @if(Session::has('message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('message') }}
                    </div>
                @endif
                <form wire:submit.prevent="changePass">
                @csrf
                <!-- to error: add class "has-danger" -->
                    <div class="form-group">
                        <label for="pass">Password Baru</label>
                        <input id="pass" type="password" class="form-control @error('password') is-invalid @enderror"
                               name="email" wire:model="password" required autocomplete="email" autofocus>
                        @error('password') <span
                            class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="confirmPass">Ulangi</label>
                        <input id="confirmPass" type="password" wire:model="password_confirmation"
                               class="form-control @error('password_confirmation') is-invalid @enderror" name="password" required
                               autocomplete="current-password">
                        @error('password_confirmation') <span
                            class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <button wire:click="backPrev" type="button" class="btn btn-secondary">Batal
                    </button>
                    <button type="submit" class="btn btn-primary">Ganti</button>
                </form>
            </div>
        </div>
    </div>
</div>
