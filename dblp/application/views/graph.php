<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
<style type="text/css">

body { 
  font: 14px helvetica neue, helvetica, arial, sans-serif;
}

#cy {
  height: 100%;
  width: 100%;
  position: absolute;
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
  transition: background-color 0.2s ease, color 0.2s ease;
}

.card-links a li:hover .label-notification,
.label-active {
  color: #44474a;
  background: #d7d9d9;
}
</style>
  
<title>dblp: computer science bibliography</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://cytoscape.github.io/cytoscape.js/api/cytoscape.js-latest/cytoscape.min.js"></script>

<script src="<?php echo base_url(); ?>assets/lib/arbor.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/cola.v3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/dagre.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/foograph.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/springy.js"></script>

<script src="http://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/jquery.qtip.min.js"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/qtip2/2.2.0/jquery.qtip.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.rawgit.com/cytoscape/cytoscape.js-qtip/2.1.0/cytoscape-qtip.js"></script>
</head>
<body> 

  <form method="POST" id='save_graph_form' action='<?php echo base_url(); ?>user/save_graph'>
    <input type="hidden" name="add_db" value='<?php echo $db_add; ?>'>
  </form>
  <form method="POST" id='level_up_form' action='<?php echo base_url(); ?>welcome/index'>
    <?php $ijs = 0; foreach ($for_level_up as $level_up_id) { ?>
      <input type="hidden" name="id[<?php echo $ijs++; ?>]" class="selected_value" value="<?php echo $level_up_id; ?>" selected="">
    <?php } ?> 
      <input type="hidden" name="level_down" class="selected_value" value='<?php echo $db_add; ?>' selected="">
  </form>
  
  <?php if(isset($level_down) && $level_down == "1"){ ?>
  <form method="POST" id='level_down_form' action='<?php echo base_url(); ?>welcome/index'>
    <?php $ijs = 0; foreach ($level_down_ids_authors as $level_down_ids_author) { ?>
      <input type="hidden" name="id[<?php echo $ijs++; ?>]" class="selected_value" value="<?php echo $level_down_ids_author; ?>" selected="">
    <?php } ?> 
  </form>
  <?php } ?>

<div id="cy"></div>
    <article>
      <div class="card-header">
        <img class="profile-photo" src="http://www.newstransparency.com/images/placeholder_male.png">
        <p style="text-align:center; font-weight:bold;"><?php echo $this->session->userdata['user']['user_name']; ?> <?php echo $this->session->userdata['user']['user_surname']; ?></p>
        <p style="text-align:center;"><?php echo $this->session->userdata['user']['user_email']; ?></p>
      </div>
      <ul class="card-links">
        <a href="<?php echo base_url(); ?>">
          <li >
            <i class="icon icon-user"></i><span class="label">Dashboard</span>
          </li>
        </a>
        <hr>
        <?php if(isset($level_down) && $level_down == "1"){ ?>
         <a href="#" id="level_down_graph">
          <li>
            <i class="icon icon-user"></i><span class="label">Level Down Graph</span>
          </li>
        </a>
        <hr>
        <?php } ?>
         <a href="#" id="level_up_graph">
          <li>
            <i class="icon icon-user"></i><span class="label">Level Up Graph</span>
          </li>
        </a>
        <hr>
         <a href="#" id="save_graph_button">
          <li>
            <i class="icon icon-user"></i><span class="label">Save This Graph</span>
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

<script  type="text/javascript" charset="UTF-8">

$("#level_up_graph").on("click",function(){
  $("#level_up_form").submit();
});

$("#level_down_graph").on("click",function(){
  $("#level_down_form").submit();
});

$("#save_graph_button").on("click",function(){
  $.post($("#save_graph_form").attr('action'),$('#save_graph_form').serialize(),function(status){
    if(status == "1"){
      alert("Graph saved!");
    }
  });
  return false;
});

$(function(){ 

  var cy = cytoscape({

  container: document.getElementById('cy'),

  style: cytoscape.stylesheet()
    .selector('node')
      .css({
        'font-size': 10,  
        'content': 'data(gene_name)',
        'text-valign': 'center',
        'color': 'yellow',
        'text-outline-width': 2,
        'text-outline-color': '#888',
        'min-zoomed-font-size': 5,
        'width': 'mapData(score, 0, 1, 20, 50)',
        'height': 'mapData(score, 0, 1, 20, 50)'
      })
    .selector('node:selected')
      .css({
        'background-color': '#000',
        'text-outline-color': '#000'
      })
    .selector('edge')
      .css({
        'curve-style': 'bezier ',
        'opacity': 1,
        'width': 'mapData(strength, 0, 0.01, 1, 20)',
      })
   
  .selector('edge:selected')
    .css({
      'line-color': 'red'
    }),
  
  elements: cy3json.elements,
  wheelSensitivity: 0.5,

  layout: {
    name: 'concentric',
    concentric: function(){
      return this.data('score');
    },
    levelWidth: function(nodes){
      return 0.5;
    },
    padding: 10
  }
});

<?php $fg = 0; foreach ($array_xc as $array_x) { ?>
 <?php $nodex = $array_x['nodes']; ?>
 <?php $boook = $array_x['books']; ?>
 <?php for ($l=0; $l < count($nodex)-1; $l++) { ?>
  <?php for ($lx=0; $lx < count($nodex); $lx++) {  ?>
    <?php if($lx>$l){ ?>
    cy.$('#<?php echo $fg; ?><?php echo $l; ?><?php echo $lx; ?>').qtip({
      content: '<?php echo ($boook["0"]); ?>',
    });
    <?php } ?>
    <?php } ?>
    <?php } ?>
<?php $fg++; } ?>

}); 

var cy3json = {
  
  "elements" : {
    "nodes" : [
    <?php $ih = 0; ?>
    <?php foreach ($authors_list as $authors_node1) { ?>
    <?php echo "{"; ?>
      "<?php echo 'data'; ?>" <?php echo ": {"; ?>
        "<?php echo 'id'; ?>" <?php echo ':' ?> "<?php echo str_replace('-','x',urlencode($authors_node1)); ?>" <?php echo ","; ?>
        "<?php echo 'gene_name' ?>" <?php echo ':'; ?> "<?php echo html_entity_decode($authors_node1, ENT_COMPAT, 'UTF-8');?>"
      <?php echo '}'; ?><?php echo ','; ?>
      "<?php echo 'position'; ?>" <?php echo ':' ?> <?php echo '{'; ?>
        "<?php echo 'x' ?>" <?php echo ':'; ?> <?php echo '7.656166076660156'; ?><?php echo ','; ?>
        "<?php echo 'y' ?>" <?php echo ':' ?> <?php echo '-74.6204605102539'; ?>
      <?php echo '}' ?><?php echo ','; ?>
      "<?php echo 'selected'; ?>" <?php echo ':'; ?> <?php echo 'false'; ?>
    <?php echo '}'; ?><?php echo ','; ?>
  <?php } ?> 
],
  "edges" : [ 
        <?php $fg = 0; foreach ($array_xc as $array_x) { 
          $nodex = $array_x['nodes'];
          for ($l=0; $l < count($nodex)-1; $l++) { ?>
           <?php for ($lx=0; $lx < count($nodex); $lx++) { ?> 
            <?php if($lx>$l){ ?>
          { data: { id:"<?php echo $fg; ?><?php echo $l; ?><?php echo $lx; ?>",source: '<?php echo str_replace("-","x",urlencode($nodex[$l])); ?>', target: '<?php echo str_replace("-","x",urlencode($nodex[$lx])); ?>', strength:0.0001, highlight: 1 }} ,
          <?php  } ?>
          <?php } ?>
        <?php } ?>
      <?php $fg++; } ?>
    ]
  }
};

$('#cy').cytoscape(function(){ 
  
  cy = this;
  var edges = cy.elements().jsons();
  var should_remove = [];
  var source_to_target = [];
  var source_to_target_ids = [];
  var on_graph_edges = [];
  var deleted_sources = [];
  var deleted_targets = [];
  var vtys = [];

  for (var i = 0; i < edges.length; i++) {
    
    if(typeof edges[i].data.source != 'undefined'){

      if(source_to_target.indexOf(edges[i].data.source+"||"+edges[i].data.target) == -1 ){

        if(source_to_target.indexOf(edges[i].data.target+"||"+edges[i].data.source) == -1){

          source_to_target_ids.push(edges[i].data.id);
          source_to_target.push(edges[i].data.source+"||"+edges[i].data.target);
          on_graph_edges.push(edges[i].data.id);
        }
        else{

           var istt = source_to_target.indexOf(edges[i].data.target+"||"+edges[i].data.source); 
           var cgsd = source_to_target_ids[istt];
           vtys.push(cgsd);
           should_remove.push(edges[i].data.id);  
        } 
      }

      else{
          
         var istt = source_to_target.indexOf(edges[i].data.source+"||"+edges[i].data.target);
         var cgsd = source_to_target_ids[istt];
         vtys.push(cgsd);    
         should_remove.push(edges[i].data.id);

      }
    }
  };

  for (var i = 0; i < should_remove.length; i++) {

    var api = cy.$("#"+should_remove[i]).qtip('api');
    var removing_book_name = api.get('content.text');
    console.log("#"+vtys[i]);
    api = cy.$("#"+vtys[i]).qtip('api');
    console.log(api);
    var current_book_name = api.get('content.text');

    api.set('content.text', current_book_name+" <br><hr> "+removing_book_name);
    cy.$("#"+vtys[i]).style("width",(parseInt(cy.$("#"+vtys[i]).style("width").split('p')[0])+2)+"px");
    cy.$("#"+should_remove[i]).remove();

  };
  
});

</script>