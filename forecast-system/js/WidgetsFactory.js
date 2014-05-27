Helpers.WidgetsFactory = Class.extend({
	_widgets_tmp: null,
	_widgets: null,
	
	initialize: function(){
		this._widgets = {};
		this._widgets_tmp = [];
	},
	
	add: function(factory){
		this._widgets_tmp.push(factory);
	},
	
	buildWidgets: function(){
		for (var i in this._widgets_tmp){
			var widget = this._widgets_tmp[i]();
			this._widgets[widget.getId()] = widget;
		}
		
		var f = $.proxy(function(i){
			var listen_to = this._widgets[i].getListenTo();
			for (var j in listen_to){
				this._widgets[listen_to[j]].onUpdate(i, $.proxy(function(data){
					this._widgets[i].update(data);
				}, this));
			}
		}, this);
		
		for (var i in this._widgets) f(i);
	}
});

create_singleton(Helpers.WidgetsFactory);