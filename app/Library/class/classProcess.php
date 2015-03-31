<?php
class classProcess  {
	public function insertDeriveClass($projectid, $name, $orgClassid, $newClassid) {
		DB::transaction(function() use($orgClassid, $name, $newClassid, $projectid)
			{
				//削减计数器的值
				DB::table('class')
					->where('id', $orgClassid)
					->decrement('number');

				//新建一个新的class
				DB::insert('insert into class (id, title, number) values (?, ?, ?)',
					array($newClassid, $name, 1));

				//更新的联系表
				DB::table('pro_to_cla')
					->whereRaw('project_id = '.$projectid.' and class_id = '.$orgClassid)
					->update(array('class_id' => $newClassid));

				//更新已有的article表
				DB::table('article')
					->whereRaw('pro_id = '.$projectid.' and cla_id = '.$orgClassid)
					->update(array('cla_id' => $newClassid));
			});
	}

	public function removeDeriveClass($projectid, $orgClassid) {
		DB::transaction(function () use ($orgClassid, $projectid)
		{
			DB::table('class')
				->where('id', $orgClassid)
				->decrement('number');
			DB::table('pro_to_cla')
				->whereRaw('project_id = '.$projectid." and class_id = ".$orgClassid)
				->delete();
			DB::table('article')
				->whereRaw('pro_id = '.$projectid." and cla_id = ".$orgClassid)
				->delete();
		});
	}

	public function removeOriginClass($projectid, $classid) {
		DB::transaction(function () use ($projectid, $classid)
		{
			DB::table('class')
				->whereRaw('id = '.$classid)
				->delete();
			DB::table('pro_to_cla')
				->whereRaw('project_id = '.$projectid." and class_id = ".$classid)
				->delete();
			DB::table('article')
				->whereRaw('pro_id = '.$projectid." and cla_id = ".$classid)
				->delete();
		});
	}
}
?>