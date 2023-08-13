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
                    <div class="fs-3 text-center">今日統計</div>
                </div>
                <div class="col-2">
                </div>
            </div>
        </div>
    </div>

    <div class="container py-3">
        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">Part.0 自選日期</div>
            </div>
            <div class="col-md-6 col-10">
                <input type="date" class="form-control input_card" id="changeDate" name="date">
            </div>
        </div>

        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">Part.1 打卡紀錄</div>
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
        <div class="row justify-content-center mb-3">
            <div class="col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div><small>持續天數</small></div>
                        <div class="float-end fs-3"><strong><?= esc($data['single_data']['consecutive_days'])?></strong></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div><small>累積天數</small></div>
                        <div class="float-end fs-3"><strong><?= esc($data['single_data']['accumulated_days'])?></strong></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center mb-3">
            <div class="col-md-8 col-12">
                <div class="fs-5 mb-2">Part.2 翻卡x新卡紀錄</div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2"><small>近7天學習狀態柱狀圖</small></div>
                        <div><canvas id="barChart"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div><small>今日測驗數</small></div>
                        <div class="float-end fs-3"><strong><?= esc($data['single_data']['today_q_count'])?></strong></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div><small>累積測驗數</small></div>
                        <div class="float-end fs-3"><strong><?= esc($data['single_data']['total_q_count'])?></strong></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div><small>新增字卡數</small></div>
                        <div class="float-end fs-3"><strong>0</strong></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="card">
                    <div class="card-body">
                        <div><small>累積字卡數</small></div>
                        <div class="float-end fs-3"><strong>0</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    const defaultData=<?php echo json_encode($data); ?>;
    
    let changeDate = document.getElementById('changeDate');
    changeDate.addEventListener("change", (e) => {
        e.preventDefault();
        let formdata= new FormData();
        formdata.append('date',e.target.value);
        myLib1.POST("<?= base_url('/statistics') ?>",formdata);
    });

    let myLib1 = {
        POST: (url,formdata) => {
            axios.post(url,formdata)
            .then((response) => {
                renderPage(response.data);
            }).catch((e) => {
                console.log(e.response.data);
            })
        },
    }

    function getBarChart(log, cards){
        new Chart(document.getElementById("barChart"), {
            type: 'bar',
            data: {
                labels: [log[0].date.slice(-5),
                        log[1].date.slice(-5),
                        log[2].date.slice(-5),
                        log[3].date.slice(-5),
                        log[4].date.slice(-5),
                        log[5].date.slice(-5),
                        log[6].date.slice(-5),],
                datasets: [
                    {
                    label: "測驗數",
                    backgroundColor: "#95CD7B",
                    stack: 'Stack 0',
                    data: [log[0].count,
                        log[1].count,
                        log[2].count,
                        log[3].count,
                        log[4].count,
                        log[5].count,
                        log[6].count],
                    },
                    {
                    label: "新卡數",
                    backgroundColor: "#E6E164",
                    stack: 'Stack 0',
                    data: [cards[0].count,
                        cards[1].count,
                        cards[2].count,
                        cards[3].count,
                        cards[4].count,
                        cards[5].count,
                        cards[6].count],
                    }
                ],
            },
            options: {
                legend: { display: false },
                scales: {
        			x: {
        				stacked: true,
        			},
        			y: {
        				stacked: true
        			}
        		},
                scales: {
                    xAxes: [{
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true,
                    }]
                },
        		responsive: true
            },
        });
    }

    function getCalender(data){
        let calender = document.getElementById('calender');
        let len = Object.keys(data).length;
        let calBody = `
                <div class="row justify-content-center mb-2">
                    <div class="col text-center">mon</div>
                    <div class="col text-center">tue</div>
                    <div class="col text-center">wed</div>
                    <div class="col text-center">thu</div>
                    <div class="col text-center">fri</div>
                    <div class="col text-center">sat</div>
                    <div class="col text-center">sun</div>
                </div>`;
        let weekday = 1;
        let first = new Date(data[0].date);
        while(weekday != first.getDay()){
            if(weekday == 1)
                calBody = calBody + `<div class="row justify-content-center mb-2">`;
            calBody = calBody + `<div class="col p-0 m-0"></div>`;
            weekday++;
        }
        data.forEach((value, index) => {
            if(weekday == 1)
                calBody = calBody + `<div class="row justify-content-center mb-2">`;
            if(value.count == 0)
                calBody = calBody + `<div class="col p-0 m-0 d-flex justify-content-center"><div class="text-center dot">${value.date.slice(-2)}</div></div>`;
            else
                calBody = calBody + `<div class="col p-0 m-0 d-flex justify-content-center"><div class="text-center dot dot-fill">${value.date.slice(-2)}</div></div>`;
            if(weekday == 7){
                calBody = calBody + `</div>`;
                weekday = 1;
            }else{
                weekday++
            }
        });
        while(weekday <= 7 && weekday > 1){
            calBody = calBody + `<div class="col p-0 m-0"></div>`;
            if(weekday == 7)
                calBody = calBody + `</div>`;
            weekday++;
        }
        calender.innerHTML = calBody;
    }

    function renderPage(data){
        changeDate.value = data.weekly_log_count[6].date;

        getBarChart(data.weekly_log_count, data.weekly_cards_count);
        getCalender(data.the_month_log_count);
    }

    renderPage(defaultData);
</script>
<?= $this->endSection()?>