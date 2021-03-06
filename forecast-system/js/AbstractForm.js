/**
 * @load Views.Abstract
 * @load Helpers.ErrorsHandler
 * @load Helpers.FieldValidator
 */
Views.AbstractForm = Views.Abstract.extend({
	
	_url: '',
	_id: 'single-form',
	_el: null,
	_data: {},
	_validator: null,
	
	initialize: function(){
		this._render();
		this._url = this._el.attr('action');
		
		this._el.submit($.proxy(function(){
			if (this._validator.hasError()) return false;
			this._data = this._el.serialize();
			this.beforeSubmit();
			$.post(this._url, this._data, $.proxy(function(res){
				this.afterSubmit(res);
				
				if (typeof res.status != 'string'){
					throw 'wrong status';
				}
				
				if (res.status == 'success'){
					this.success(res.data);
				} else if (res.status == 'error') {
					this.error(res.data);
				} else {
					throw 'wrong status';
				}
			}, this), 'json');
			
			return false;
		}, this));
		
		this._validator = new Helpers.FieldValidator(this);
	},
	
	beforeSubmit: function(){
		this.disableUI();
	},
	
	afterSubmit: function(data){},
	
	success: function(data){},
	
	error: function(data){
		this._showErrors(this._validator.setServerErrors(data));
		this.enableUI();
	},
	
	disableUI: function(){
		this._el.find('input, select, textarea, button').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	},
	
	enableUI: function(){
		this._el.find('input, select, textarea, button').each(function(){
			$(this).removeAttr('disabled');
		});
	},
	
	_showErrors: function(data){
		new Helpers.ErrorsHandler(data).show(this._el.find("#errors-container"));
	}
});