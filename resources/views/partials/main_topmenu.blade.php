<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon" onClick="set_sidebar()">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- COMPANY PROFILE -->
                <span class="d-flex align-items-center">
                    <span class="text-start ms-xl-2">
                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                            {{ request()->session()->get('populus_company_nama') }}
                        </span>

                        <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                            {{ request()->session()->get('populus_company_alamat') }}
                        </span>
                    </span>
                </span>
            </div>

            <div class="d-flex align-items-center">
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode"
                        onClick="set_theme()">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                src="{{ url('storage/users/' .request()->session()->get('user_id') .'.jpg') }}"
                                alt="Header Avatar">

                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                    {{ request()->session()->get('user_nama') }}
                                </span>

                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                    {{ request()->session()->get('level_nama') }}
                                </span>
                            </span>
                        </span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">
                        <h6 class="dropdown-header">Welcome {{ request()->session()->get('user_nama') }}</h6>

                        <a class="dropdown-item" href="{{ url('/userprofile') }}">
                            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Profile</span>
                        </a>

                        <a class="dropdown-item" href="{{ url('/changepassword') }}">
                            <i class="mdi mdi-pencil text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Change Password</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="#" data-bs-toggle="modal" onClick="set_lockscreen()"
                            data-bs-target="#modalLockScreen"><i
                                class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Lock screen</span>
                        </a>
                        <a class="dropdown-item" href="{{ url('/logout') }}"><i
                                class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Modal flip -->
<div id="modalLockScreen" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true"
    data-bs-backdrop="static" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card mt-4">
                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Lock Screen</h5>
                            <p class="text-muted">Enter your password to unlock the screen!</p>
                        </div>

                        <div class="user-thumb text-center">
                            <img src="{{ url('storage/users/' .request()->session()->get('user_id') .'.jpg') }}"
                                class="rounded-circle img-thumbnail avatar-lg" alt="thumbnail">
                            <h5 class="font-size-15 mt-3">{{ request()->session()->get('user_nama') }}</h5>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                id="lblLockscreen" hidden>
                                Login failed
                            </div>
                        </div>

                        <div class="p-2 mt-4">
                            <div class="mb-3">
                                <label class="form-label" for="txtPasswordLockscreen">Password</label>

                                <input type="password" class="form-control" id="txtPasswordLockscreen"
                                    name="passwordlockscreen" placeholder="Enter Password" required autofocus>
                            </div>

                            <div class="mb-2 mt-4">
                                <button class="btn btn-success w-100" onClick="set_unlockscreen()">Masuk
                                    Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <p class="mb-0">Bukan anda? Silakan login lagi <a href="{{ url('/logout') }}"
                            class="fw-semibold text-primary text-decoration-underline">
                            Mulai Ulang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
