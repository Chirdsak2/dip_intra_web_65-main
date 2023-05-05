/**
*	@jax : jax is a class AJAX framework, it's object oriented written in JavaScript class style. jax is simply easy and ready to use.
*
*	@version 2
*	@author Niruth Amnuaysilp (nirutha@gmail.com) Thaidev.com's Webmaster
*
*/

	function jax()
	{
		var _ajaxRequest; 
		var _param="";
		var _length=0;
		var _place="";

	}

	jax.prototype.change=function()
	{
		if(this._ajaxRequest.readyState == 4)
		{
			document.getElementById(this._place).innerHTML = this._ajaxRequest.responseText;
		}
		else
		{
			document.getElementById(this._place).innerHTML = "<img src=../images/indic.gif><br> Please wait...";
		}
	}

	jax.prototype.jaxinit=function()
	{
		this._param="";
		this._length=0;
		try{
			this._ajaxRequest = new XMLHttpRequest();
		} 
		catch (e)
		{	 
			try
			{
				this._ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
			} 
			catch (e) 
			{
				try
				{
					this._ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (e)
				{	 
					alert("jax not support!");
					return false;
				}
			}
		}
	}
	
	jax.prototype.getformdata=function(input)
	{
		return input.value;
	}
	jax.prototype.addvar=function(name,value)
	{
		if (this._length==0)
			this._param+="?";

		this._param+=name;
		this._param+="=";
		this._param+=value;
		this._param+="&";

		//alert(this._param);

		this._length=this._length+1;	
	}
	jax.prototype.getstring=function()
	{
		return this._param;
	}
	jax.prototype.clear=function()
	{
		this._param="";
		this._length=0;
	}

	jax.prototype.processjax=function(url,place)
	{
		this.addvar("temp",Math.random());

		this._place=place;

		//alert(this.getstring());
		
		this._ajaxRequest.open("GET", url + this.getstring() , true);

		var self=this;
		this._ajaxRequest.onReadyStateChange = function()
		{
			self.change();
		}

		this._ajaxRequest.send(null);
	}