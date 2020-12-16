<?php
// Crypto Wallet
// Author: Crypto Wallet
if(!defined('PWV1_INSTALLED')){
    header("HTTP/1.0 404 Not Found");
	exit;
}
$b = protect($_GET['b']);

if($b == "add_category") {
	?>
	<br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Knowledge Base</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li>Add category</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">

           <div class="col-md-12">
					<div class="card">
                        <div class="card-body">
			<?php
			if(isset($_POST['btn_add'])) {
				$name = protect($_POST['name']);
				
				$check = $db->query("SELECT * FROM pw_knowledge_categories WHERE name='$name'");
				if(empty($name)) { echo error("Please enter a category name."); }
				elseif($check->num_rows>0) { echo error("This category name is already used. Please choose another. "); }
				else {
					$time = time();
					$insert = $db->query("INSERT pw_knowledge_categories (name,created) VALUES ('$name','$time')");
					echo success("Category <b>$name</b> was added successfully.");
				}	
			}
			?>
			
			<form action="" method="POST">
				<div class="form-group">
									<label>Category name</label>
									<input type="text" class="form-control" name="name">
								</div>
				<button type="submit" class="btn btn-primary" name="btn_add"><i class="fa fa-plus"></i> Add</button>
			</form>		
		</div>
	</div>
	</div>
	<?php
} elseif($b == "edit_category") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM pw_knowledge_categories WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=knowledge"); }
	$row = $query->fetch_assoc();
	?>
	<br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Knowledge Base</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li>Edit Category</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">

           <div class="col-md-12">
					<div class="card">
                        <div class="card-body">
			<?php
			if(isset($_POST['btn_save'])) {
				$name = protect($_POST['name']);
				$check = $db->query("SELECT * FROM pw_knowledge_categories WHERE name='$name'");
				if(empty($name)) { echo error("Please enter a category name."); }
				elseif($row['name'] !== $name && $check->num_rows>0) { echo error("This category name is already used. Please choose another. "); }
				else {
					$time = time();
					$update = $db->query("UPDATE pw_knowledge_categories SET name='$name' WHERE id='$row[id]'");
					$query = $db->query("SELECT * FROM pw_knowledge_categories WHERE id='$id'");
					$row = $query->fetch_assoc();
					echo success("Your changes was saved successfully.");
				}	
			}
			?>
			
			<form action="" method="POST">
					<div class="form-group">
									<label>Category name</label>
									<input type="text" class="form-control" name="name" value="<?php echo $row['name']; ?>">
								</div>
				<button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
			</form>
		</div>
	</div>
	</div>
	<?php
} elseif($b == "delete_category") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM pw_knowledge_categories WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=knowledge"); }
	$row = $query->fetch_assoc();
	?>
	<br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Knowledge Base</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li>Delete Category</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">

           <div class="col-md-12">
					<div class="card">
                        <div class="card-body">
			<?php
			if(isset($_GET['confirm'])) {
                $delete = $db->query("DELETE FROM pw_knowledge_categories WHERE id='$row[id]'");
                $delete = $db->query("DELETE FROM pw_knowledge_articles WHERE category_id='$row[id]'");
				echo success("Category <b>$row[name]</b> was deleted.");
			} else {
				echo info("Are you sure you want to delete category <b>$row[name]</b>?<br/><small>All articles in this category will be deleted.</small>");
				echo '<a href="./?a=knowledge&b=delete_category&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=knowledge" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	</div>
	<?php
} elseif($b == "add_article") {
    $id = protect($_GET['category']);
	$GetCategory = $db->query("SELECT * FROM pw_knowledge_categories WHERE id='$id'");
	if($GetCategory->num_rows==0) { header("Location: ./?a=knowledge"); }
	$cat = $GetCategory->fetch_assoc();
    ?>
    <br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Knowledge Base</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li>Add Article in <?php echo $cat['name']; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">

           <div class="col-md-12">
					<div class="card">
                        <div class="card-body">
			<?php
			if(isset($_POST['btn_add'])) {
				$title = protect($_POST['title']);
				$content = addslashes($_POST['content']);
				$check = $db->query("SELECT * FROM pw_knowledge_articles WHERE title='$title'");
				if(empty($title) or empty($content)) { echo error("All fields are required."); }
				elseif($check->num_rows>0) { echo error("Article with this name already exists. Please choose another. "); }
				else {
					$time = time();
					$insert = $db->query("INSERT pw_knowledge_articles (title,category_id,content,created) VALUES ('$title','$cat[id]','$content','$time')");
					echo success("Article <b>$title</b> was added in category <b>$cat[name]</b>.");
				}	
			}
			?>
			
			<form action="" method="POST">
				<div class="form-group">
									<label>Title</label>
									<input type="text" class="form-control" name="title">
								</div>
								<div class="form-group">
									<label>Content</label>
									<textarea class="cleditor" rows="15" name="content"></textarea>
								</div>
				<button type="submit" class="btn btn-primary" name="btn_add"><i class="fa fa-plus"></i> Add</button>
			</form>		
		</div>
	</div>
	</div>
    <?php
} elseif($b == "edit_article") {
    $id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM pw_knowledge_articles WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=knowledge"); }
	$row = $query->fetch_assoc();
    ?>
 <br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Knowledge Base</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li>Edit Article</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">

           <div class="col-md-12">
					<div class="card">
                        <div class="card-body">
			<?php
			if(isset($_POST['btn_save'])) {
				$title = protect($_POST['title']);
				$content = addslashes($_POST['content']);
				$check = $db->query("SELECT * FROM pw_knowledge_articles WHERE title='$title'");
				if(empty($title) or empty($content)) { echo error("All fields are required."); }
				else {
					$time = time();
                    $update = $db->query("UPDATE pw_knowledge_articles SET title='$title',content='$content' WHERE id='$row[id]'");
                    $query = $db->query("SELECT * FROM pw_knowledge_articles WHERE id='$row[id]'");
                    $row = $query->fetch_assoc();
					echo success("Your changes was saved successfully.");
				}	
			}
			?>
			
			<form action="" method="POST">
				<div class="form-group">
									<label>Title</label>
									<input type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>">
								</div>
								<div class="form-group">
									<label>Content</label>
									<textarea class="cleditor" rows="15" name="content"><?php echo $row['content']; ?></textarea>
								</div>
				<button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save Changes</button>
			</form>		
		</div>
	</div>
	</div>
    <?php
} elseif($b == "delete_article") {
    $id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM pw_knowledge_articles WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=knowledge"); }
	$row = $query->fetch_assoc();
    ?>
    <br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Knowledge Base</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li>Delete Article</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">

           <div class="col-md-12">
					<div class="card">
                        <div class="card-body">
			<?php
			if(isset($_GET['confirm'])) {
                $delete = $db->query("DELETE FROM pw_knowledge_articles WHERE id='$row[id]'");
				echo success("Article <b>$row[title]</b> was deleted.");
			} else {
				echo info("Are you sure you want to delete article <b>$row[title]</b>?");
				echo '<a href="./?a=knowledge&b=delete_article&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=knowledge&b=articles&category='.$row[category_id].'" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	</div>
    <?php
} elseif($b == "articles") {
    $id = protect($_GET['category']);
	$GetCategory = $db->query("SELECT * FROM pw_knowledge_categories WHERE id='$id'");
	if($GetCategory->num_rows==0) { header("Location: ./?a=knowledge"); }
	$cat = $GetCategory->fetch_assoc();
    ?>
    <br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Knowledge Base</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li><a href="./?a=knowledge&b=add_article&category=<?php echo $id; ?>"><i class="fa fa-plus"></i> Add Article</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">

           <div class="col-md-12">
					<div class="card">
                        <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="85%">Article name</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                            $limit = 20;
                            $startpoint = ($page * $limit) - $limit;
                            if($page == 1) {
                                $i = 1;
                            } else {
                                $i = $page * $limit;
                            }
                            $statement = "pw_knowledge_articles WHERE category_id='$id'";
                            $query = $db->query("SELECT * FROM {$statement} ORDER BY id LIMIT {$startpoint} , {$limit}");
                            if($query->num_rows>0) {
                                while($row = $query->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['title']; ?></td>
                                        <td>
                                            <a href="./?a=knowledge&b=edit_article&id=<?php echo $row['id']; ?>" title="Edit"><span class="badge badge-primary"><i class="fa fa-pencil"></i> Edit</span></a> 
                                            <a href="./?a=knowledge&b=delete_article&id=<?php echo $row['id']; ?>" title="Delete"><span class="badge badge-danger"><i class="fa fa-trash"></i> Delete</span></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="2">No have knowledge articles yet. <a href="./?a=knowledge&b=add_article&category='.$id.'">Click here</a> to add.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    $ver = "./?a=knowledge&b=articles&category=$id";
                    if(admin_pagination($statement,$ver,$limit,$page)) {
                        echo admin_pagination($statement,$ver,$limit,$page);
                    }
                    ?>
                </div>
                </div>
            </div>
    <?php
} else {
?>
<br>
		<br>
		<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Knowledge Base</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
							<li><a href="./?a=knowledge&b=add_category"><i class="fa fa-plus"></i> Add Category</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">

           <div class="col-md-12">
					<div class="card">
                        <div class="card-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="70%">Category name</th>
					<th width="15%">Articles</th>
					<th width="15%">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
				$startpoint = ($page * $limit) - $limit;
				if($page == 1) {
					$i = 1;
				} else {
					$i = $page * $limit;
				}
				$statement = "pw_knowledge_categories";
				$query = $db->query("SELECT * FROM {$statement} ORDER BY id LIMIT {$startpoint} , {$limit}");
				if($query->num_rows>0) {
					while($row = $query->fetch_assoc()) {
						?>
						<tr>
							<td><a href="./?a=knowledge&b=articles&category=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
							<td><?php $articles = $db->query("SELECT * FROM pw_knowledge_articles WHERE category_id='$row[id]'"); echo $articles->num_rows; ?> <a href="./?a=knowledge&b=articles&category=<?php echo $row['id']; ?>"><span class="badge badge-primary"><i class="fa fa-search"></i> View</span></a></td>
							<td>
								<a href="./?a=knowledge&b=edit_category&id=<?php echo $row['id']; ?>" title="Edit"><span class="badge badge-primary"><i class="fa fa-pencil"></i> Edit</span></a> 
                                <a href="./?a=knowledge&b=delete_category&id=<?php echo $row['id']; ?>" title="Delete"><span class="badge badge-danger"><i class="fa fa-trash"></i> Delete</span></a>
							</td>
						</tr>
						<?php
					}
				} else {
					echo '<tr><td colspan="3">No have knowledge categories yet. <a href="./?a=knowledge&b=add_category">Click here</a> to add.</td></tr>';
				}
				?>
			</tbody>
		</table>
		<?php
		$ver = "./?a=knowledge";
		if(admin_pagination($statement,$ver,$limit,$page)) {
			echo admin_pagination($statement,$ver,$limit,$page);
		}
		?>
	</div>
	</div>
</div>
<?php
}
?>