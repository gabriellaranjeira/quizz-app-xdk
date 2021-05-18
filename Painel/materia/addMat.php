<?php
session_start();
if(!isset($_SESSION['user'])){
	header('location:index.php');
}
	include_once("conn.php");	
if(isset($_POST['acao']) && $_POST['acao'] == "inserir"){
	$nome = trim($_POST['nome']);
	$desc = trim($_POST['desc']);
	$curso = trim($_POST['curso']);
	$materia = $conn->prepare('INSERT INTO materia(nome,
														descricao,
														idcurso) VALUES (:nome,
														:descricao,
														:curso)');
	$materia->bindParam(':nome', $nome);
	$materia->bindParam(':descricao', $desc);
	$materia->bindParam(':curso', $curso);
	if($materia->execute()){
		header('location:home.php?msg=Matéria cadastrado com sucesso!');
	}else{
		header('location:home.php?msg=Não foi possivel cadastrar o matéria!');

	}
}else{
	$consulta = $conn->prepare("SELECT * FROM curso");
	$consulta->execute();
}
		

?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>ADMINISTRACAO</title>
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<!-- end: CSS -->
	

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->
	
	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->
		
	<!-- start: Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- end: Favicon -->
	
		
		
		
</head>

<body>
		<!-- start: Header -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="home.php"><span>AREA ADMINISTRATIVA</span></a>
			
			</div>
		</div>
	</div>
	<!-- start: Header -->
	
		<div class="container-fluid-full">
		<div class="row-fluid">
				
			<!-- start: Main Menu -->
			<div id="sidebar-left" class="span2">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="home.php"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Inicio</span></a></li>	
						<li><a href="quiz.php"><i class="icon-edit"></i><span class="hidden-tablet"> Adicionar quiz</span></a></li>
						<li><a href="niveis.php"><i class="icon-edit"></i><span class="hidden-tablet"> Administrar Niveis</span></a></li>
						<li><a href="adQuiz.php"><i class="icon-edit"></i><span class="hidden-tablet"> Administrar contas</span></a></li>
						<li><a href="curso.php"><i class="icon-edit"></i><span class="hidden-tablet"> Administrar Cursos</span></a></li>
						<li><a href="materia.php"><i class="icon-edit"></i><span class="hidden-tablet"> Administrar Matérias</span></a></li>

					</ul>
				</div>
			</div>
			<!-- end: Main Menu -->
			
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.html">Home</a>
					<i class="icon-angle-right"></i> 
				</li>
				<li>
					<i class="icon-edit"></i>
					<a href="#">Forms</a>
				</li>
			</ul>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Contas</h2>
					</div>
					<div class="box-content">
						<form action="" method="post" class="form-horizontal">
						  <fieldset>
							<div class="control-group">
							  <label class="control-label" for="typeahead">Nome da matéria: </label>
							  <div class="controls">
								<input type="text" class="span6 typeahead" name="nome">
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="typeahead">Descrição: </label>
							  <div class="controls">
								<input type="text" class="span6 typeahead" name="desc">
							  </div>
							</div>

							<div class="control-group">
							  <label class="control-label" for="typeahead">Curso da matéria: </label>
							  <div class="controls">
								 <select name="curso">
								 <?php while($row = $consulta->fetch(PDO::FETCH_OBJ)){ ?>
								  <option value="<?php echo $row->id; ?>"><?php echo $row->nome; ?></option>
								  <?php } ?>
								</select> 
							  </div>
							</div>

							<input type="hidden" name="acao" value="inserir">                                                           
							
							<div class="form-actions">

							  <button type="submit" class="btn btn-primary">ENTER</button>
							  <button type="reset" class="btn">RESET</button>
							</div>
						  </fieldset>
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->

			
			
			

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
	
	<div class="clearfix"></div>
	
	<footer>

		<p>
			<span style="text-align:left;float:left">&copy; 2013 <a href="http://jiji262.github.io/Bootstrap_Metro_Dashboard/" alt="Bootstrap_Metro_Dashboard">Bootstrap Metro Dashboard</a></span>
			
		</p>

	</footer>
	
	<!-- start: JavaScript-->

		<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery-migrate-1.0.0.min.js"></script>
	
		<script src="js/jquery-ui-1.10.0.custom.min.js"></script>
	
		<script src="js/jquery.ui.touch-punch.js"></script>
	
		<script src="js/modernizr.js"></script>
	
		<script src="js/bootstrap.min.js"></script>
	
		<script src="js/jquery.cookie.js"></script>
	
		<script src='js/fullcalendar.min.js'></script>
	
		<script src='js/jquery.dataTables.min.js'></script>

		<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.js"></script>
	<script src="js/jquery.flot.pie.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	
		<script src="js/jquery.chosen.min.js"></script>
	
		<script src="js/jquery.uniform.min.js"></script>
		
		<script src="js/jquery.cleditor.min.js"></script>
	
		<script src="js/jquery.noty.js"></script>
	
		<script src="js/jquery.elfinder.min.js"></script>
	
		<script src="js/jquery.raty.min.js"></script>
	
		<script src="js/jquery.iphone.toggle.js"></script>
	
		<script src="js/jquery.uploadify-3.1.min.js"></script>
	
		<script src="js/jquery.gritter.min.js"></script>
	
		<script src="js/jquery.imagesloaded.js"></script>
	
		<script src="js/jquery.masonry.min.js"></script>
	
		<script src="js/jquery.knob.modified.js"></script>
	
		<script src="js/jquery.sparkline.min.js"></script>
	
		<script src="js/counter.js"></script>
	
		<script src="js/retina.js"></script>

		<script src="js/custom.js"></script>
	<!-- end: JavaScript-->
	
</body>
</html>
