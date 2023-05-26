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
                <div>- 翻卡 (1 coin for 1 correct)</div>
                <div>- 拼寫 (5 coin for 1 correct)</div>
            </div>
        </div>
    </div>

    <div class="container py-3">
        <div class="row justify-content-center my-3">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center py-5"><a href="<?= base_url('/quizlets/new') ?>" class="a_black stretched-link">建立新測驗</a></div>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="container py-3">
        <div class="row justify-content-center my-3">
            <div class="col-md-10">
                
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-3 d-flex align-items-center justify-content-center bg_dark_blue rounded-start">
                            <div class="text-center">99%</div>
                        </div>
                        <div class="col-9 card-body">
                            <div class="fs-5">
                                <strong><a href="" class="a_black stretched-link"></a></strong>
                            </div>
                            <p class="ellipsis"></p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
<script>
    let groupBtn = document.getElementById("groupBtn");
    document.getElementById("bigBtn").addEventListener("click",(e) => {
        groupBtn.classList.toggle("d-none");
    })
</script>
<?= $this->endSection()?>