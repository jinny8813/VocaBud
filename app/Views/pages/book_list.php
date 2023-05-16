<?= $this->extend("layout/template")?>
<?= $this->section('content')?>
<section class="min-vh-100 bg_light">
    <div class="w-100">
        <img class="img-fluid" src="<?= base_url('../../public/assets/images/banner.jpg') ?>" alt="">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="position-relative">
                    <div class="position-absolute top-100 start-50 translate-middle d-flex justify-content-between align-items-center w-100">
                        <div class="card w-75">
                            <div class="card-body">
                                <div class="text-center fs-3">的個人主頁的個人主頁</div>
                            </div>
                        </div>
                        <div>
                            <a href="#" class="btn p-2"><i class="fa-fw fa-solid fa-arrow-up"></i></a>
                        </div>
                        <div>
                            <a href="#" class="btn p-2"><i class="fa-fw fa-solid fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="row justify-content-center m-3">
            <div class="col-5 pt-5 row justify-content-end">
                <div style="width:100px">
                    <img class="img-fluid" src="<?= base_url('../../public/assets/images/icon.png') ?>" alt="">
                </div>
            </div>
            <div class="col-7 pt-5">
                <h2>LetsgoVoc</h2>
                <p>Let's enjoy learning in an efficient way.</p>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection()?>