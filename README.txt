CREATING A MODULE:
	1. Gawa ng folder sa '/modules' containing default.php and default.css
		ex: 
			modules/add_announcement/default.php	//html structure and functionalities of add_announcement
			modules/add_announcement/default.css	//css for add_announcements only
			
	2. Link gamit ang '?page=<name_of_folder>'
		ex:
			//link
				<a href="?page=add_announcement">Add an announcement</a>
			//header
				header('location: ?page=add_announcement');
	3. Keribels niyo na 'yan. :D
	
	NOTES: 
		Lahat ng form actions ay 'action=""' tapos sa umpisa ng index.php ilalagay 'yung:
			if(isset($_POST['<name_of_submit>']) header('location: ?page='<module_name>');
		para uniform at walang loophole? :D
		
		Para sa javascripts, gawa nalang rin ng 'default.js' sa folder kung san kailangan 'yung default.js. Automatic included na 'yun.
		
		Para sa gagawa ng view_announcement, sa modules/home/default.php 'yung kailangan i-edit. 'Yun kasi unang lalabas pagka-login. Para lang sa view 'yon, pwede gumawa ng pani-bagong module para sa ibang functions ng announcement. :)
	
	SUGGESTION: Kung na-hihirapan sa layout/template ng CSS, pag-aralan ang row-fluid, span1 - span12, container-fluid classes ng bootstrap. Mas madadalian kayo. Promise. :D
	
	Sa Sunday na ko makakapag-net ulit kaya sinabi ko na lahat dito. Haha. Sorry. :) Go group 1!