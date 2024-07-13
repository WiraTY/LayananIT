<?= $this->extend('pendaftar/layout/main'); ?>

<?= $this->section('content'); ?>

<main id="main">

    <section id="features" class="features">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Login Pendaftar</h2>
                            <form action="/processLogin" method="post">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Features Section -->

</main><!-- End #main -->

<?= $this->endSection('content') ?>;