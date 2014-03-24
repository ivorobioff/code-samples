/**
 * @load Views.AbstractComponent
 * @load Libs.Event
 */
Views.AbstractWidget = Views.AbstractComponent.extend({
	_components: null,
	_xpath_attachments: null,
		
	initialize: function(id){
		this._super(id);
		this._components = {};
		this._xpath_attachments = {};
	},
	
	attachComponent: function(component){
        component.setParent(this);
		this._components[component.getId()] = component;
        component.onGetAttached();
	},
	
	attachByXPath: function (xpath, component){
		this._xpath_attachments[xpath] = component;
	},
	
	render: function(){
		this.onRender();
		var that = this;
		
		for (var xpath in this._xpath_attachments){
			
			this._el.find(xpath).each(function(){
				var c = that._xpath_attachments[xpath]($(this));
				that.attachComponent(c);
			});
		}
		
		for (var id in this._components){
			var c = this._components[id];
			c.setElement(this._el.find("[data-component-id='" + c.getId() + "']"));
			c.render();
		}
	},
		
	getComponent: function(id){
		return this._components[id];
	},
	
	hasComponent: function(id){
		return typeof this._components[id] != "undefined";
	},
	
	getComponents: function(){
		return this._components;
	}
});