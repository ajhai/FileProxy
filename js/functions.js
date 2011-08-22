var currentOption = 0;

function passResponse() 
{
		document.hform.user.value = document.login.user_temp.value;
		document.hform.pass.value = MD5(document.login.pass_temp.value);
		document.login.pass_temp.value = "";
		document.hform.submit();
}


function test(uid) {
	var rl;
	rl = document.getElementById('urls').value;
	rl = rl.replace(/^\s*|\s*$/g,'');
	if(rl != "")
	{
		new Ajax.PeriodicalUpdater('progress', 'ajax/progressBar.py',
			{
				method:'get',
				parameters: {urls: document.getElementById('urls').value},
				frequency: 2, 
				decay: 1
			});
		document.getElementById('genURLForm').style.display = "none";
		document.getElementById('progress').innerHTML = "<img src='i/loading.gif' />";
		new Ajax.Updater('genURL','ajax/test.py?uid=' + uid,
		  {
			method:'get',
			parameters: {urls:  document.getElementById('urls').value},
			onSuccess: function(transport){
			  var response = transport.responseText || "no response text";
			  document.getElementById('progress').style.display = "none";
			},
			onFailure: function(){ alert('Something went wrong...') }
		  });
	}
}