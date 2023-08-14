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
                    <div class="fs-3 text-center">測驗大廳</div>
                </div>
                <div class="col-2">
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-10 pb-4">
                <div>-----------------------------</div>
                <div>-----------------------------</div>
            </div>
        </div>
    </div>

    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">自訂義測驗</div>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center py-3"><a href="<?= base_url('/quizlets/new') ?>" class="a_black stretched-link">創建測驗</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">我的測驗捷徑</div>
            </div>
        </div>
    </div>
</section>
<script>
    
</script>
<?= $this->endSection()?>