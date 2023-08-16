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
                <div class="fs-5 mb-2">Part.1 今日翻卡測驗狀況</div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2"><small id="doughnutText">今日測驗狀況圓餅圖</small></div>
                        <div class="row justify-content-center ">
                            <div class="col-6">
                                <canvas id="doughnutChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">Part.2 翻卡測驗x新卡紀錄</div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2"><small>近7天學習狀態柱狀圖</small></div>
                        <div>
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">Part.3 打卡紀錄</div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2"><small>本月學習打卡紀錄</small></div>
                        <div id="calender"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection()?>