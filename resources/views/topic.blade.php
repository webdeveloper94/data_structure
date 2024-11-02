

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

<h1>{{ $topicm->title }}<span class="color_h1"></span></h1>

<p>{{ $topicm->content }}</p>
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