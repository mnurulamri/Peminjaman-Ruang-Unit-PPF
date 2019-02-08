<div class="root">
    <div class="containerx">
        <ul class="progressbar">
            <li class="active kemahasiswaan"></li>
            <li class="active koordinator"></li>
            <li class="active manajer_ppf"></li>
        </ul>
    </div>
</div>

<style type="text/css">
/* status progress */
.containerx{
  width: 250px; /*100%;*/
  position: absolute;
  z-index: 1;
}
.progressbar li{
  float: left;
  width: 20%;
  position: relative;
  text-align: center;
  list-style: none;
}

.progressbar li:before{
  content:counter(step);
  counter-increment: step;
  width: 20px;
  height: 20px;
  border: 2px solid #bebebe;
  display: block;
  border-radius: 50%;
  background: white;
  color: #bebebe;
  text-align: center;
  font-weight: bold;
    /*
  margin: 0 auto 10px auto;
    line-height: 27px;
  */
}
.progressbar{
  counter-reset: step;
}
.progressbar li:after{
  content: '';
  position: absolute;
  width:100%;
  height: 3px;
  background: #979797;
  top: 11px;
  left: -50%;
  z-index: -1;
}

  /*.progressbar li.active:before, .progressbar li.active:after {
  border-color: #3aac5d;
background: #3aac5d;
  color: white
}*/
.progressbar li:first-child:after{
    content: none;
}

/*
.progressbar li.active + li:after{
   background: #3aac5d;
}

.progressbar li.active:before{
   background: #3aac5d;
   border-color: #3aac5d;
   color: white
}


.progressbar li.active + li:before{
  border-color: #3aac5d;
  background: #3aac5d;
  color: white
}*/

.progressbar li.kemahasiswaan.active:before{
  border-color: #3aac5d; /* circle */
}
.progressbar li.kemahasiswaan.active:after{
  border-color: #3aac5d;  /* line */
}
.progressbar li.koordinator.active:before{
  border-color: #fa0; /* circle */
}
.progressbar li.koordinator.active:after{
  background: #fa0;  /* line */
}
.progressbar li.manajer_ppf.active:before{
  border-color: purple;
}
.progressbar li.manajer_ppf.active:after{
  background: purple;
}
</style>