

<title>Massivlar</title>



<x-main>

<div class='w3-sidebar w3-collapse' id='sidenav'>
  <div id='leftmenuinner'>
    <div id='leftmenuinnerinner'>
<!--  <a href='javascript:void(0)' onclick='close_menu()' class='w3-button w3-hide-large w3-large w3-display-topright' style='right:16px;padding:3px 12px;font-weight:bold;'>&times;</a>-->
<h2 class="left"><span class="left_h2">Mavzular</span> to'plami</h2>
@foreach ($topics as $topic)
<a target="_top" href="{{ route('topic.show', ['topic' => $topic->id]) }}">{{$topic->title}}</a>
@endforeach


      <br><br>
    </div>
  </div>
</div>
<div class='w3-main w3-light-grey' id='belowtopnav' style='margin-left:250px;'>

  <div class='w3-row w3-white'>
    
    <div class='w3-col l10 m12' id='main'>
      <div id='mainLeaderboard' style='overflow:hidden;'>
        <!-- MainLeaderboard-->

        <!--<pre>main_leaderboard, all: [728,90][970,90][320,50][468,60]</pre>-->
        <div id="adngin-main_leaderboard-0"></div>
        <!-- adspace leaderboard -->

      </div>

<h1>Massivlar<span class="color_h1"></span></h1>

<div class="w3-panel w3-info intro">
    <p>Massiv — bu bir xil turdagi elementlarni bir joyda saqlash imkonini beruvchi ma'lumotlar tuzilmasidir. Ular ko'plab dasturlash tillarida keng qo'llaniladi va ma'lumotlarni samarali tarzda boshqarish uchun qulay imkoniyatlar yaratadi. Massivlar yordamida biz katta hajmdagi ma'lumotlarni tartibga solish, saqlash va ularga kirish imkoniyatiga ega bo'lamiz.</p>
</div>
<hr>

<h1>Massivning Turlari</h1>
<p>Massivlar bir nechta turga bo'linadi. Ularning eng keng tarqalganlari:</p>
<p>Bir o'lchovli massiv: Bu turdagi massivlar faqat bitta o'lchovga ega bo'lib, ular bir qator ma'lumotlarni saqlash imkonini beradi. Masalan, raqamlar yoki so'zlar ro'yxatini saqlashda ishlatiladi</p>
<p>Ko'p o'lchovli massiv: Bu turdagi massivlar ikki yoki undan ko'p o'lchovga ega bo'lib, ular jadval ko'rinishida ma'lumotlarni saqlash imkonini beradi. Masalan, 2D massivlar (jadval) qator va ustunlar orqali ma'lumotlarni tartibga soladi.</p>

<div class="w3-example">
<h3>Misol(Massivlarning php da qo'llanishi)</h3>
<div class="w3-code notranslate htmlHigh">
    
    // Oddiy massiv yaratish <br>
    $mevalar = array("olma", "banan", "apelsin");<br><br>
    
    // Massiv elementlarini ko'rsatish <br>
    echo $mevalar[0]; // olma <br>
    echo $mevalar[1]; // banan <br>
    echo $mevalar[2]; // apelsin <br>
    
    
</div>
<a class="w3-btn w3-margin-bottom" href="tryitfb35.html?filename=tryhtml_default" target="_blank">Try it Yourself &raquo;</a>
</div>
<hr>

<h2>Massivlar dasturlashda bir qancha afzalliklarga ega:</h2>
<p>Tezkor kirish: Massiv ichidagi ma'lumotlarga indekslar orqali tezkor kirish mumkin, bu esa ularni tezda qayta ishlash imkonini beradi.</p>
<p>Resurslarni tejash: Massivlar yordamida bir xil turdagi ma'lumotlarni bir joyda saqlash orqali xotira resurslarini tejash mumkin.</p>
<p>Tizimlash: Massivlar ma'lumotlarni tartibga solish va boshqarishni osonlashtiradi, bu esa dasturiy ta'minotning samaradorligini oshiradi.</p>


<hr>
<div id="midcontentadcontainer" style="overflow:auto;text-align:center">
<!-- MidContent -->
<!-- <p class="adtext">Advertisement</p> -->

  <div id="adngin-mid_content-0"></div>
  
</div>
<hr>
<h2>Massivlar Qo'llanilishi</h2>
<p>Massivlar dasturlashda juda ko'p joylarda qo'llaniladi. Ular:</p>
<p>Matematika va statistikada: Raqamlar va statistik ma'lumotlarni saqlash uchun.</p>
<p>O'yinlar va grafika dasturlarida: O'yin obyektlari va grafika elementlarini saqlash uchun.</p>
<p>Ma'lumotlar bazalarida: Ma'lumotlarni saqlash va qayta ishlashda foydalaniladi.</p>


<style>
#img_mylearning {
  max-width:100%;
}
</style>

<br>
<!--
<a class="ws-btn w3-margin-bottom"
 href="https://profile.w3schools.com/log-in?redirect_url=https%3A%2F%2Fmy-learning.w3schools.com"
 target="_blank"
 style="font-size: 18px;padding-left:25px;padding-right:25px;
 font-family : 'Source Sans Pro', sans-serif;
 margin-top:6px;"
 >
 Sign up
</a>
-->
<hr>


<br>

<style>  

#w3_cert_badge {
  position: absolute;
  right: 5%;
  width: 220px;
  transform: rotate(10deg);
  bottom: -20%;
}

#w3_cert_arrow {
  position: absolute;
  right: 220px;
  width: 220px;
  transform: rotate(10deg);
  bottom: 0;
  z-index: 1;
}

#getdiploma {
  position: relative;
  padding: 0 60px 50px 60px;
  margin-bottom: 125px;
  border-radius: 16px;
  background-color: #282A35;
  color: #FFC0C7;
  font-family: 'Source Sans Pro', sans-serif;
}

#getdiploma h2 {
  font-size:50px;
  margin-top: 1em;
  margin-bottom: 1em;
  font-family: 'Source Sans Pro', sans-serif
}

#getdiploma p {
  font-size: 42px;
  margin-top: 1em;
  margin-bottom: 1em;
  font-family: 'Source Sans Pro', sans-serif
}

#getdiploma a {
  border-radius: 50px;
  mxargin-top: 50px;
  font-size: 18px;
  background-color: #04AA6D;
  padding: 17px 55px
}

#getdiploma a:hover,
#getdiploma a:active {
  background-color: #059862 !important;
}


@media screen and (max-width: 1442px) {
  #w3_cert_arrow {
    right: 212px;
    bottom: -15px;
  }
}


@media screen and (max-width: 1202px) {
  #w3_cert_arrow {
    display: none;
  }
}

@media screen and (max-width: 992px) {
  #w3_cert_arrow {
    display: block;
  }
}


@media screen and (max-width: 800px) {
  #w3_cert_arrow {
    display: none;
  }
  #getdiploma h2 {
    font-size: 44px;
  }
  #getdiploma p {
    font-size: 30px;
  }

  #getdiploma a {
    width: 100%;
  }
  #w3_cert_badge {
    top: -16px;
    right: -8px;
    width: 100px;
  }
  #getdiploma  {
    margin-bottom: 55px;
  }
}
</style>


  
<style>
.ribbon-vid {
  font-size:12px;
  font-weight:bold;
  padding: 6px 20px;
  left:-20px;
  top:-10px;
  text-align: center;
  color:black;
  border-radius:25px;
}
</style>








<style>
/*Remove this style after 20. April 2024*/
#err_message {
  padding:8px 16px 16px 40px;
  border-radius:5px;
  display:none;
  position:relative;
  background-color:#2D3748;
  color:#FFF4A3;
  font-family:'Source Sans Pro', sans-serif;
}
#err_message h2 {
  font-family:'Source Sans Pro', sans-serif;
}
#err_message p {
  color:#f1f1f1;
}
#err_message #close_err_message {
  position:absolute;
  right:0;
  top:0;
  font-size:20px;
  cursor:pointer;
  width:30px;
  height:30px;
  text-align:center;
}
#err_message #close_err_message:hover {
  background-color:#FFF4A3;
  color:#2D3748;
  border-radius:50%
}
</style>


<script src="../lib/topnav/maine5ea.js?v=1.0.32"></script>
<script src="../lib/w3schools_footera602.js?update=20240910"></script>
<script src="../lib/w3schools_features0dce.js?update=20240927"></script>



</x-main>