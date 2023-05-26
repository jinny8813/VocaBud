<?= $this->extend("layout/template")?>
<?= $this->section('content')?>
<section class="min-vh-100 bg_light">
    <div class="container-fluid bg_green bg_green_title">
        <div class="row justify-content-center">
            <div class="col-md-8 row justify-content-center align-items-center">
                <div class="col-1 p-0">
                    <a href="<?= base_url('/quizlets') ?>" class="btn btn_low_key p-0"><i class="fa-fw fa-regular fa-hand-point-left"></i></a>
                </div>
                <div class="col-10 pt-3 pb-4">
                    <div class="fs-3 text-center">測驗中</div>
                </div>
                <div class="col-1">
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center my-3">
            <div class="col-md-8 my-3">
                <div class="card showCards" id="frontCard">
                    <div class="card-body row align-items-center">
                        <div class="col-12">
                            <h5 class="card-title text-center fs-1" id="frontTitle">00000</h5>
                            <div class="text-center ellipsis small" id="partOfSpeech">1111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111</div>
                            <div class="text-center ellipsis small" id="pronunciation">222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222</div>
                        </div>
                    </div>
                </div>
                <div class="card showCards d-none" id="backCard">
                    <div class="card-body row align-items-center">
                        <div class="col-12">
                            <h5 class="card-title text-center fs-1" id="backContent"></h5>
                            <div class="text-center ellipsis small" id="e_sentence">11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111</div>
                            <div class="text-center ellipsis small" id="c_sentence">22222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-3">
                <div class="row g-0 justify-content-center mb-3" id="flipCard">
                    <a href="#" class="btn col" style="background-color: #d6d2c8; color:black">翻卡</a>
                </div>
                <div class="row g-0 justify-content-center mb-3" id="theChoice">
                    <button class="btn me-3 col" style="background-color: #7781de;" id="theChoice1">忘記</button>
                    <button class="btn mx-3 col" style="background-color: #63afd9;" id="theChoice2">模糊</button>
                    <button class="btn ms-3 col" style="background-color: #5ec7b4;" id="theChoice3">熟悉</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    
</script>
<?= $this->endSection()?>