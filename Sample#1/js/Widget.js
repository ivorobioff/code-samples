/**
 * @load Views.AbstractWidget
 * @load Libs.Event
 */
Views.Widget = Views.AbstractWidget.extend({
	
	_listen_to: null,
	_followers: null,
	_event: null,
    _page: null,

	initialize: function(id, page){
		this._super(id);
		this._page = page;
		this._followers = [];
		this._event = new Libs.Event();
	},
	
	onRender: function(){
		var that = this;

		this._el.find(".togl").click(function(){
			var el = $(this);
			var i_holder = el.find("i");

			if (i_holder.hasClass('fa-minus-square')){
				i_holder.removeClass('fa-minus-square').addClass('fa-plus-square');
			} else {
				i_holder.removeClass('fa-plus-square').addClass('fa-minus-square');
			}

            var body =  el.parents(".panel").find(".panel-body");

            if (body.hasClass("faky-hidden")){
                body.removeClass("faky-hidden");
                that._saveState(0);
            } else {
                body.addClass("faky-hidden");
                that._saveState(1);
            }

		});
		
		this._initDialogControls();
	},

    _initDialogControls: function(){
        var components = this.getComponents();
        var that = this;

        var init_click = function(dialog){
            that._el.find("#show-" + dialog.getId()).click(function(){
                dialog.show();
                return false;
            });
        };

        for (var i in components){
            var c = components[i];
            if (c instanceof Views.AbstractDialog) init_click(c);
        }
    },

    _saveState: function(state){
        var widgets_state = Cookies.get('widgets_state');
        if (typeof widgets_state == 'undefined') widgets_state = "{}";

        widgets_state = JSON.parse(widgets_state);
        widgets_state[this._page + "-" + this.getId() + "-closed"] = state;

        Cookies.set("widgets_state", JSON.stringify(widgets_state), {
            expires: "01/01/2100",
            path: "/"
        });
    },

	listenTo: function(widgets){
		this._listen_to = widgets;
	},
	
	getListenTo: function(){
		return this._listen_to;
	},
	
	/**
	 * Runs when the other widget gets updated
	 */
	update: function(data){
		this.getComponent("graph").update(data.chart);
		this.getComponent("dataset-dialog").updateDataset(data.dataset);
        this.getComponent("zoom-dialog").updateGraph(data.chart);
	},
	
	/**
	 * This widget allows to be listened since it got this method
	 * @param wid
	 * @param callback
	 */
	onUpdate: function (wid, callback){
		this._followers.push(wid);
		this._event.add(wid + "-update", callback)
	},
	
	getFollowers: function(){
		return this._followers;
	},
	
	trigger: function(data){
		this.update(data[this.getId()]);
		
		for (var i in this._followers){
			var follower = this._followers[i];
			this._event.trigger(follower + "-update", [data[follower]]);
		}
	}
});