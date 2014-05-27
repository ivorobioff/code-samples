/**
 * @load Views.AbstractWidget
 */
Views.Dataset = Views.AbstractWidget.extend({

	initialize: function(){
		this._super("dataset");
	},
	
	onRender: function(){
		var that = this;
		
		this._el.find("#show-all-years").click(function(){
			var el = $(this);

			el.parents(".nav-tabs").find("li.active").removeClass("active");
			el.parent().addClass("active");

			var content = el.parents(".tabbable").find(".tab-content");
			content.find(".tab-pane").addClass("active");
			content.find(".title-year").removeClass("hide");
			return false;
		});
				
		this._el.find(".nav-tabs li a")
			.not(this._el.find("#show-all-years"))
			.click(function(){
				$(this).parents(".tabbable").find(".title-year").addClass("hide");
				that._el.find(".nav-tabs li.active").removeClass("active");
				$(this).parent().addClass("active");
				that._el.find(".tab-pane.active").removeClass("active");
				that._el.find("#content-" + $(this).attr("data-year")).addClass("active");
				
				return false;
			});
		
		if (this._grid_class != null){
			this._el.find(".hook-grid").each(function(){
				new that._grid_class($(this));
			});
		}
	},
	
	disableUI: function(){
		var blocker = this._el.find(".tab-content .ui-blocker");
		
		if (blocker.length == 0){
			blocker = $("<div class=\"ui-blocker\">&nbsp;</div>");
			this._el.find(".tab-content").append(blocker);
		}
		
		blocker.show();
	},
	
	enableUI: function(){
		var blocker = this._el.find(".tab-content .ui-blocker");
		blocker.hide();
	},
	
	update: function(data){
		var components = this.getComponents();
		for (i in components){
			components[i].update(data[i]);
		}
	}
});