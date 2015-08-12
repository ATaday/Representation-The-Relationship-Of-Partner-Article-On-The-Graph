<html>
<head>
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/buttons.css">
  <title></title>
</head>
<body>
  <section>
    <p class="no-article">
      <?php if($this->session->flashdata('error') != ""){
        echo $this->session->flashdata('error');
      } else{ 
        echo "&nbsp";
      } ?>
    </p>
  <input type="text" class="filter" id="filter" placeholder="Type to filter" action="<?php echo base_url(); ?>dashboard/auto_complete/"/>
  <ul id="list" class="List">
         <?php foreach ($authors as $author) { ?>
         <li>
            <?php echo $author["author_name"]; ?>
            <span style="float:right;">
              <a href="#" class="add-button" data-id="<?php echo $author['author_id']; ?>" data-name='<?php echo $author['author_name']; ?>'>+ Add</a>
            </span>
         </li>
        <?php } ?>
        </ul>
    </section>

    <div id="form">
      <form action="<?php echo base_url(); ?>welcome/index" method="POST">
        <input type="submit" style="display:none;" id="show_graph" value="Gönder">
        <a href='#' onClick='$("#show_graph").click();' class='signup'>Show The Graph</a>
      </form>
    </div>

    <article>
      <div class="card-header">
        <img class="profile-photo" src="http://www.newstransparency.com/images/placeholder_male.png">
        <p style="text-align:center; font-weight:bold;"><?php echo $this->session->userdata['user']['user_name']; ?> <?php echo $this->session->userdata['user']['user_surname']; ?></p>
        <p style="text-align:center;"><?php echo $this->session->userdata['user']['user_email']; ?></p>
      </div>
      <ul class="card-links">
        <a href="<?php echo base_url(); ?>">
          <li class="active">
            <i class="icon icon-user"></i><span class="label">Dashboard</span>
          </li>
        </a>
        <hr>
        <a href="<?php echo base_url(); ?>user/my_graphs">
          <li >
            <i class="icon icon-list-alt"></i><span class="label">Your Graphs</span>
          </li>
        </a>
        <hr>
        <a href="<?php echo base_url() ?>user/logout">
          <li>
            <i class="icon icon-time"></i><span class="label">Logout</span>
          </li>
        </a>
      </ul>
    </article>
</body>
</html>

<script type="text/javascript">

$("#submit").on("click",function(){
  $("#form form").submit();
});

  var count = 0;

  $("body").on("click",".add-button",function(){
    var thiz = $(this);
    var author_id = thiz.attr("data-id");
    var author_name = thiz.attr("data-name");
    
    thiz.parent().parent().fadeOut();
    $("#choose").hide();
    $("#form form").prepend("<input type='text' name='authors["+count+"]' class='selected_value' value='"+author_name+"' selected><br>");
    $("#form form").prepend("<input type='hidden' name='id["+count+++"]' class='selected_value' value='"+author_id+"' selected><br>");
    
    return false;

  }); 

  $('#filter').on('input', function() { 
    var thiz = $(this).val();
    if(thiz.length > 2){
      $.post($(this).attr("action")+encodeURIComponent(thiz),function(data){
        var obj = $.parseJSON(data);

        for (var i = 0; i < obj.length; i++) {

          var aut_id = obj[i].author_id;
          var aut_name = obj[i].author_name;
          var html = "";

          html+= "<li>";
            html += aut_name;
            html += '<span style="float:right;">';
              html += '<a href="#" class="add-button" data-id="'+aut_id+'" data-name="'+aut_name+'">+ Add</a>';
            html += "</span>";
          html += "</li>";

         $("ul#list").prepend(html);
         remove_same();
        };

      });
    }

});

function remove_same(){

  var ids = ["-1"];

  $( "ul#list li a" ).each(function( index ) {
    var thiz = $(this);
    console.log(thiz.attr('data-id'));
    if(ids.indexOf(thiz.attr('data-id')) == "-1"){
      ids.push(thiz.attr('data-id'));
    }
    else{
      thiz.parent().parent().remove();
    }
  });
}

</script>

<style type="text/css">
* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

body {
  padding: 1em;
  font-family: 'Open Sans';
  font-size: 14px;
  font-weight: 300;
  background-color: #c1bdba;
  color: #5C393D;
}

#form h2 {
  color: #fefefe;
}

#form {
  float: left;
}

.selected_value {
  padding: 4px;
  margin-bottom: 4px;
}

.add-button {
  text-decoration: none;
  color: #EEE;
  border: solid 1px #333;
  background-color: #666;
  padding: 4px;
  border-radius: 1px;
}

section {
  width: 400px;
  display: inline-block;
  float: left;
  margin-right: 100px;
}

input.filter {
  width: 100%;
  padding: 16px 8px;
  font-size: 16px;
  outline: none;
  background-color: #E78584;
  border: none;
  color: #5C393D;
}

.List {
  width: 100%;
  margin: 8px 0;
  list-style: none;
    padding-left: 0;
}
.List > li {
  padding: 12px 8px;
  background-color: #F2B7BD;
  border-bottom: 1px solid #5C393D;
  transition: all 0.1s ease;
}
.List > li.is-hidden {
  height: 0;
  font-size: 0;
  padding: 0;
  border: none;
  visibility: hidden;
}

::-webkit-input-placeholder {
  color: #5C393D;
}

:-moz-placeholder {
  /* Firefox 18- */
  color: #5C393D;
}

::-moz-placeholder {
  /* Firefox 19+ */
  color: #5C393D;
}

article {
  background: #fff;
  border: 1px solid #bbb;
  border-radius: 4px;
  width: 160px;
  float: right;
  -webkit-box-shadow: 0px 0px 16px rgba(50, 50, 50, 0.24);
}

.card-header {
  padding: 4px;
  background: #eee;
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
  border-bottom: 1px solid #ccc;
}

.card-header button {
  font-size: 13px;
  cursor: pointer;
  width: 100%;
  background: #3498db;
  border: none;
  color: #fff;
  border-radius: 4px;
  padding: 8px;
  -webkit-font-smoothing: antialiased;
}

.card-header button:hover {
  background: #51a7e0;
}

.card-header img {
  width: 152px;
  border-radius: 2px;
}

.card-links {
  list-style: none;
  margin: 0;
  padding: 0;
}

.card-links hr {
  border-bottom: 0;
  border-top: 1px solid #ddd;
  margin: 0;
}

.card-links a {
  text-decoration: none;
  color: #000000;
}

.card-links a li {
  margin: 0;
  padding: 14px 6px;
  border-left: 4px solid #fff;
  transition: background-color 0.2s ease,
              border-left 0.2s ease,
              color 0.2s ease;
}

.card-links a li:hover {
  border-left: 4px solid #3498db;
  background: #f6f6f6;
  color: #44474a;
}

.card-links a li.active {
  border-left: 4px solid #E78584 !important;
  background: #f6f6f6;
  color: #44474a;
}

.card-links a li i {
  position: absolute;
  margin-left: 4px;  
}

.link-favorites {
  border-bottom-left-radius: 4px;
}

.label {
  position: relative;
  left: 26px;
  top: -1px;
  font-size: 12px;
}

.label-notification {
  float: right;
  font-size: 10px;
  color: #8f9496;
  background: #eceded ;
  padding: 4px;
  border-radius: 4px;
  margin: -2px 4px 0 0;
  transition: background-color 0.2s ease,
              color 0.2s ease;
}

.card-links a li:hover .label-notification,
.label-active {
  color: #44474a;
  background: #d7d9d9;
}

.no-article {
      font-size: 19px;
    font-weight: bold;
}

</style>

<script type="text/javascript">

var filter = document.getElementById('filter');
var list = document.getElementById('list');
var listItems = list.querySelectorAll('li');

filter.addEventListener('keyup', function(e) {

  var val = new RegExp(e.target.value, 'gi');

  for(var i=0; i<listItems.length; i++) {

    if( e.target.value.length > 0) {
      var text = listItems[i].innerHTML;
    
      if( !text.match(val)) {
        listItems[i].classList.add('is-hidden');
      } else {
        listItems[i].classList.remove('is-hidden');
      }
    } else {
      listItems[i].classList.remove('is-hidden');
    }   
  }
}); 

</script>