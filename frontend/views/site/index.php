<?php

/* @var $this yii\web\View */

$this->title = 'Тестовое задание';

$vote = \frontend\models\Vote::find()->orderBy(['id' => SORT_DESC])->one();

\yii\web\JqueryAsset::register($this);
?>
<script>
function create() {
    var f = $('#f').val();
    var s = $('#s').val();
    if (s != "" && f != "") {
        $.ajax({
            url: '/ajax/create',
            type: 'POST',
            data: ({s: s, f: f, _csrf: '<?=Yii::$app->getRequest()->csrfToken?>'}),
            success: function (e) {
                upd();
            }
        });
    }
}

function upd() {
    $.ajax({
        url:'/ajax/upd',
        type:'POST',
        success:function (e) {
            if (!e == false)
            {
                $('.jumbotron').empty();
                $('.jumbotron').append(e);
            }
            else
            {

            }

        }
    });
}
upd();

function update() {

    $.ajax({
        url: '/ajax/update',
        type: 'POST',
        success: function (e) {
            if (e == true) {

                $('#startbtn').attr('disabled', true);

            }
            else {
                $('#startbtn').attr('disabled', false);

            }

        }
    });
}
    function timer() {

        $.ajax({
            url:'/ajax/timer',
            type:'POST',
            success:function (e) {
                $('#timer').text('Таймер: '+e+' мин');
            }
        });
}
function updateTimer() {
    $.ajax({
        url:'/ajax/utimer',
        type:'POST',
        success:function (e) {
            var s = JSON.parse(e);

            $('#ucount').text('|Число голосов: '+s.votes+' чел')
        }
    });
}
function vote() {

    var time = $('#dd').val();
    var name = $('#name').val();
    if (!name == "") {
        $.ajax({
            url: '/ajax/vote',
            type: 'POST',
            data: ({time: time, name: name}),
            success: function (e) {
                $('#votebtn').attr('disabled', true);
            }
        });
    }
}
function predicts() {

    var name = $('#name').val();
    var dd = $('.dd');
    dd.empty();
    $.ajax({
    url:'/ajax/pred',
    type:'POST',
    data:({field:name.split(' ').reverse()[0]}),
    success:function (e) {
       if (e != "")
       {
           dd.empty();
           dd.append(e);
       }
       else
       {

           dd.empty();
       }
    }

});
}
function predes(ame) {
    var name = $('#name');
    var dd = $('.dd');
    var s = name.val().split(' ');
    var string = "";
    if (name == "")
    {
        name.val();
        name.val(string);
    }
    else
    {

        for(var i = 0;i < s.length;i++)
        {
            var d = s[i];
            if (ame.match(d) != null)
            {
                s[i] = ame;
            }
        }
        for(var i = 0;i < s.length;i++)
        {
            if (i == 0)
            {
                string += s[i];
            }
            else
            {
                string += " "+s[i];
            }
        }

        name.val();
        name.val(string);
    }
    dd.empty();


}
function hidediagram() {
    $.ajax({
        url:'/ajax/remdia',
        type:'POST',
        success:function (e) {

        }

    });
}
update();
setInterval(update,5000);
setInterval(upd,10000);

function acceptv(id) {
    $.ajax({
        url:'/ajax/accept',
        type:'POST',
        data:({id:id}),
        success:function (e) {

        }

    });
}

function decline(id) {
    $.ajax({
        url:'/ajax/decline',
        type:'POST',
        data:({id:id}),
        success:function (e) {

        }

    });
}
</script>
<style>

    </style>
<?php
if (Yii::$app->user->id == $vote['aid'])
{
    echo '<script>setInterval(timer,1000);</script>';
}
?>
<div class="site-index">

    <div class="jumbotron">

    </div>
<input  type="number" placeholder="Первая Фаза" id="f" class="col-md-6 col-xs-6 col-sm-6">
    <input type="number" placeholder="Вторая Фаза" id="s" class="col-md-6 col-xs-6 col-sm-6">
<button id="startbtn" onclick="create()" class="col-md-12 col-xs-12 col-sm-12 btn">Создать</button>
</div>
