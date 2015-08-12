<html>
<head>
  <title>My Graphs</title>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="http://tablesorter.com/__jquery.tablesorter.min.js"></script>
</head>

<style type="text/css">

html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
  margin: 0;
  padding: 0;
  border: 0;
  font-size: 100%;
  font: inherit;
  vertical-align: baseline;
  outline: none;
  -webkit-font-smoothing: antialiased;
  -webkit-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

html { overflow-y: scroll; }

body { 
  background: #eee;
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 62.5%;
  line-height: 1;
  color: #c1bdba;
  padding: 22px 10px;
  padding-bottom: 55px;
}

::selection { background: #5f74a0; color: #fff; }
::-moz-selection { background: #5f74a0; color: #fff; }
::-webkit-selection { background: #5f74a0; color: #fff; }

br { display: block; line-height: 1.6em; } 

article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section { display: block; }
ol, ul { list-style: none; }

input, textarea { 
  -webkit-font-smoothing: antialiased;
  -webkit-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  outline: none; 
}

blockquote, q { quotes: none; }

blockquote:before, blockquote:after, q:before, q:after { content: ''; content: none; }

strong, b { font-weight: bold; } 

table { border-collapse: collapse; border-spacing: 0; }

img { border: 0; max-width: 100%; }

h1 { 
  font-family: 'Amarante', Tahoma, sans-serif;
  font-weight: bold;
  font-size: 3.6em;
  line-height: 1.7em;
  margin-bottom: 10px;
  text-align: center;
}

/** page structure **/
#wrapper {
  display: block;
  width: 850px;
  background: #fff;
  margin: 0 auto;
  padding: 10px 17px;
  -webkit-box-shadow: 2px 2px 3px -1px rgba(0,0,0,0.35);
}

#keywords {
  margin: 0 auto;
  font-size: 1.2em;
  margin-bottom: 15px;
}

#keywords thead {
  cursor: pointer;
  background: #c9dff0;
}

#keywords thead tr th { 
  font-weight: bold;
  padding: 12px 30px;
  padding-left: 42px;
}

#keywords thead tr th span { 
  padding-right: 20px;
  background-repeat: no-repeat;
  background-position: 100% 100%;
}

#keywords thead tr th.headerSortUp, #keywords thead tr th.headerSortDown {
  background: #acc8dd;
}

#keywords thead tr th.headerSortUp span {
  background-image: url('http://i.imgur.com/SP99ZPJ.png');
}

#keywords thead tr th.headerSortDown span {
  background-image: url('http://i.imgur.com/RkA9MBo.png');
}

#keywords tbody tr { 
  color: #555;
}

#keywords tbody tr td {
  text-align: center;
  padding: 15px 10px;
}

#keywords tbody tr td.lalign {
  text-align: left;
}

article {
  background: #fff;
  border: 1px solid #bbb;
  border-radius: 4px;
  width: 160px;
  position: absolute;
  top: 6px;
  right: 6px;

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
  transition: background-color 0.2s ease, border-left 0.2s ease, color 0.2s ease;
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

</style>

<body>
  <div id="wrapper">
  <h1>Your Saved Graphs</h1>  
  <table id="keywords" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th><span>Graph No</span></th>
        <th><span>Graph Authors</span></th>
        <th><span>Graph Created</span></th>
        <th><span>Actions</span></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($saved_graphs as $graph) { ?>
      <tr>
        <td class="lalign"><strong>#<?php echo str_pad($graph['id'],6,"0",STR_PAD_LEFT); ?></strong></td>
        <td>
          <?php foreach ($graph['authors_name'] as $author) { ?>
          <?php echo $author; ?><hr>
          <?php } ?>
        </td>
        <td><?php echo $graph['created'] ?></td>
        <td><a href="<?php echo base_url(); ?>user/delete_graph/<?php echo $graph['id']; ?>">Delete</a> | <a href="<?php echo base_url(); ?>user/draw_graph/<?php echo $graph['id']; ?>">Draw Graph</a></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
 </div> 

    <article>
      <div class="card-header">
        <img class="profile-photo" src="http://www.newstransparency.com/images/placeholder_male.png">
        <p style="text-align: center;font-weight: bold;font-size: 20px;color: #000;padding: 4px;"><?php echo $this->session->userdata['user']['user_name']; ?> <?php echo $this->session->userdata['user']['user_surname']; ?></p>
        <p style="text-align:center;color: #000;font-size: 15px;"><?php echo $this->session->userdata['user']['user_email']; ?></p>
      </div>
      <ul class="card-links">
        <a href="<?php echo base_url(); ?>">
          <li >
            <i class="icon icon-user"></i><span class="label">Dashboard</span>
          </li>
        </a>
        <hr>
        <a href="<?php echo base_url(); ?>user/my_graphs">
          <li class="active">
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
$(function(){
  $('#keywords').tablesorter(); 
});
</script>