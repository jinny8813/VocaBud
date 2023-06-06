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
            <div class="col-md-8 mb-2">
                <div class="text-center fs-5" id="theIndex">0 / 50</div>
                <div class="text-center d-none" id="theId"></div>
            </div>
            <div class="col-md-8 mb-3">
                <div class="card-inner" id="flip-card">
                    <div class="card-front" id="frontCard">
                        <div class="card showCards">
                            <div class="card-body row align-items-center">
                                <div class="col-12">
                                    <h5 class="card-title text-center fs-1" id="frontTitle"></h5>
                                    <div class="text-center ellipsis small" id="partOfSpeech"></div>
                                    <div class="text-center ellipsis small" id="pronunciation"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-back" id="backCard">
                        <div class="card showCards">
                            <div class="card-body row align-items-center">
                                <div class="col-12">
                                    <h5 class="card-title text-center fs-1" id="backContent"></h5>
                                    <div class="text-center ellipsis small" id="e_content"></div>
                                    <div class="text-center ellipsis small" id="e_sentence"></div>
                                    <div class="text-center ellipsis small" id="c_sentence"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="showCards">
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-3">
                <div class="row g-0 justify-content-center mb-3" id="flipCard">
                    <a href="#" class="btn col" style="background-color: #C2B79E; color:black">翻卡</a>
                </div>
                <div class="row g-0 justify-content-center mb-3 d-none" id="theChoice">
                    <button class="btn me-3 col" style="background-color: #7781de;" id="theChoice1">忘記</button>
                    <button class="btn mx-3 col" style="background-color: #63afd9;" id="theChoice2">模糊</button>
                    <button class="btn ms-3 col" style="background-color: #5ec7b4;" id="theChoice3">熟悉</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    const bigArr=<?php echo json_encode($cards); ?>;
    let len =Object.keys(bigArr).length;

    let currentIndex=0;
    const theIndex = document.getElementById('theIndex');
    const theId = document.getElementById('theId');

    const frontCard = document.getElementById('frontCard');
    const frontTitle = document.getElementById('frontTitle');
    const partOfSpeech = document.getElementById('partOfSpeech');
    const pronunciation = document.getElementById('pronunciation');

    const backCard = document.getElementById('backCard');
    const backContent = document.getElementById('backContent');
    const e_content = document.getElementById('e_content');
    const e_sentence = document.getElementById('e_sentence');
    const c_sentence = document.getElementById('c_sentence');

    const flipCard = document.getElementById('flipCard');
    const theChoice = document.getElementById('theChoice');
    const theChoice1 = document.getElementById('theChoice1');
    const theChoice2 = document.getElementById('theChoice2');
    const theChoice3 = document.getElementById('theChoice3');

    flipCard.addEventListener('click', () => {
        backCard.classList.remove('d-none');
        document.getElementById('flip-card').classList.add('flipped');
        flipCard.classList.add('d-none');
        theChoice.classList.remove('d-none');
    })

    theChoice1.addEventListener('click', () => {
        storeSelection(theId.textContent,1);
    })

    theChoice2.addEventListener('click', () => {
        storeSelection(theId.textContent,3);
    })

    theChoice3.addEventListener('click', () => {
        storeSelection(theId.textContent,5);
    })

    function storeSelection(id,score){
        let formdata= new FormData();
        formdata.append('s_id',id);
        formdata.append('score',score);
        myLib1.POST("<?= base_url('/quizlets/flashcard') ?>",formdata);
    }

    let myLib1 = {
        POST: (url,formdata) => {
            axios.post(url,formdata)
            .then((response) => {
                if(currentIndex>=len){
                    window.location.href = `<?= base_url('/quizlets')?>`;
                }else{
                    setNext();
                }
            }).catch((e) => {
                console.log(e.response.data);
            })
        },
    }

    function setNext(){
        backCard.classList.add('d-none');
        flipCard.classList.remove('d-none');
        theChoice.classList.add('d-none');

        theIndex.innerText = currentIndex+1;
        theId.innerText = bigArr[currentIndex]['s_id'];

        frontTitle.innerText = bigArr[currentIndex]['title'];
        partOfSpeech.innerText = bigArr[currentIndex]['part_of_speech'];
        pronunciation.innerText = bigArr[currentIndex]['pronunciation'];
        backContent.innerText = bigArr[currentIndex]['content'];
        e_content.innerText = bigArr[currentIndex]['e_content'];
        e_sentence.innerText = bigArr[currentIndex]['e_sentence'];
        c_sentence.innerText = bigArr[currentIndex]['c_sentence'];

        document.getElementById('flip-card').classList.remove('flipped');

        currentIndex++;
    }

    setNext()
</script>
<?= $this->endSection()?>