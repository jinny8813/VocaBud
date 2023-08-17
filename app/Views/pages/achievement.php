<?= $this->extend("layout/template")?>
<?= $this->section('content')?>
<section class="min-vh-100 bg_light">
    <div class="container-fluid bg_green">
        <div class="row justify-content-center">
            <div class="col-md-8 row justify-content-center align-items-center">
                <div class="col-1 p-0">
                    <a href="#" class="btn btn_low_key p-0"><i class="fa-fw fa-regular fa-hand-point-left"></i></a>
                </div>
                <div class="col-1 p-0">
                    <a href="#" class="btn btn_low_key p-0"><i class="fa-fw fa-solid fa-info"></i></a>
                </div>
                <div class="col-8 p-3">
                    <div class="fs-3 text-center">里程碑圖鑑</div>
                </div>
                <div class="col-2">
                </div>
            </div>
        </div>
    </div>

    <div class="container py-3">
        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">Part.1 創建字卡里程碑</div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2"><small>累積創建字卡數目</small></div>
                        <div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">Part.2 翻卡測驗里程碑</div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2"><small>累積翻卡測驗數目</small></div>
                        <div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">Part.3 金幣抽卡圖鑑</div>
            </div>
            <div class="col-md-8 col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2"><small>動物園</small></div>
                        <div class="row justify-content-center">                            
                            <img src="<?= base_url('../../public/assets/images/badges/rabbit.jpg') ?>" class="col-md-3 col-2 p-1 rounded-circle w-25 badge_gray" />
                            <img src="<?= base_url('../../public/assets/images/badges/rabbit.jpg') ?>" class="col-md-3 col-2 p-1 rounded-circle w-25 badge_gray" />
                            <img src="<?= base_url('../../public/assets/images/badges/rabbit.jpg') ?>" class="col-md-3 col-2 p-1 rounded-circle w-25 badge_gray" />
                            <img src="<?= base_url('../../public/assets/images/badges/rabbit.jpg') ?>" class="col-md-3 col-2 p-1 rounded-circle w-25" />
                            <img src="<?= base_url('../../public/assets/images/badges/rabbit.jpg') ?>" class="col-md-3 col-2 p-1 rounded-circle w-25 badge_gray" />
                            <img src="<?= base_url('../../public/assets/images/badges/rabbit.jpg') ?>" class="col-md-3 col-2 p-1 rounded-circle w-25 badge_gray" />
                            <img src="<?= base_url('../../public/assets/images/badges/rabbit.jpg') ?>" class="col-md-3 col-2 p-1 rounded-circle w-25 badge_gray" />
                            <img src="<?= base_url('../../public/assets/images/badges/rabbit.jpg') ?>" class="col-md-3 col-2 p-1 rounded-circle w-25 badge_gray" />
                            <img src="<?= base_url('../../public/assets/images/badges/rabbit.jpg') ?>" class="col-md-3 col-2 p-1 rounded-circle w-25 badge_gray" />
                            <img src="<?= base_url('../../public/assets/images/badges/rabbit.jpg') ?>" class="col-md-3 col-2 p-1 rounded-circle w-25 badge_gray" />
                            <img src="<?= base_url('../../public/assets/images/badges/rabbit.jpg') ?>" class="col-md-3 col-2 p-1 rounded-circle w-25 badge_gray" />
                            <img src="<?= base_url('../../public/assets/images/badges/rabbit.jpg') ?>" class="col-md-3 col-2 p-1 rounded-circle w-25 badge_gray" />
                            <img src="<?= base_url('../../public/assets/images/badges/rabbit.jpg') ?>" class="col-md-3 col-2 p-1 rounded-circle w-25 badge_gray" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2"><small>美食街</small></div>
                        <div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">Part.3 週期活動圖鑑</div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2"><small>環遊世界</small></div>
                        <div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection()?>