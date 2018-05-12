<?php

class News
{
	
	public $title='any';
	public $content='any';
	public $author='any';
	public $access=0;
	public $visible=0;
	public $reg_date='any';
	public $id=-1;
	public $icon='';
	
	public function Add($title,$content,$author,$access,$icon,$visible)
	{
		$news = new News();
		$db = new DB();
		$news->id = $db->Max('id','news')+1;
		$news->title = $title;
		$news->content = $content;
		$news->author = $author;
		$news->access = $access;
		$news->icon = $icon;
		$news->reg_date = strval(date("d.m.Y h:m:s"));
		$db->query("insert into news (id,title,content,author,access,icon,registered,visible) values (".strval($news->id).",'$title','$content','$author','$access','$icon','$reg_date', $visible)");
		return $news;
	}
	
	public function update($title,$content,$author,$access,$icon,$visible)
	{
		
		$this->title = $title;
		$this->content = $content;
		$this->author = $author;
		$this->access = $access;
		$this->icon = $icon;
		$this->visible = $visible;
		
		$db = new DB();
		$db->query("update news set title='$title', visible=$visible, content='$content', author='$author', access=$access, icon='$icon' where id=".strval($this->id));
		
	}
	
	public GetById($id)
	{
		$db = new DB();
		$res = $db->query("select * from news where id=$id");
		if($res->num_rows>0)
		{
			$res = $res->fetch_assoc();
			$news = new News();
			$news->id=$id;
			$news->title = $res['title'];
			$news->content = $res['content'];
			$news->author = $res['author'];
			$news->access = $res['access'];
			$news->icon = $res['icon'];
			$news->visible = $res['visible'];
			$news->ddate = $res['registered'];
			return $news;
		}
		return null;
	}
	
	public function Delete($id)
	{
		$db = new DB();
		$db->query("delete from news where id=$id");
	}
	
}

?>