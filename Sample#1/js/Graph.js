/**
 * @load Views.Abstract
 */
Views.Graph = Views.Abstract.extend({
	
	_data: null,
	_title: null,
	
	initialize: function(el, data, title){
        this._el = el;
		this._data = data;
		this._title = title == "undefined" ? null : title;

        this.render();
	},
	
	render: function(){
        var pos = this._getCurrentDataPos();
        var max = this._data.total_categories > 11 ? 11 : this._data.total_categories - 1;

        var min = pos - 5;
        if (min < 0 ) min = 0;

        max += min;

        if (max >= this._data.total_categories) max = this._data.total_categories - 1;
        if (max >= 11) min = max - 11;

        var current_date = new Date();

		this._el.highcharts({
			chart: {
				type: "line"
			},
			xAxis: {
				categories: this._data.categories,
				max: max,
                min: min,

				labels: {
					rotation: -45,
			        formatter: function(){
                        if (((current_date.getMonth() + 1) + "/" + current_date.getFullYear()) == this.value){
                            return "<span style=\"font-weight: bold\">" + this.value + "</span>";
                        }
                        return this.value;
                    }
                },

                plotLines: [{
                    color: '#FF0000',
                    width: 1,
                    value: pos
                }]
			},

            yAxis: {
              title: null
            },

			series: this._data.data,

			scrollbar: {
		        enabled: this._data.total_categories <= 12 ? false : true

		    },

	        title: {
				text: this._title
	        },
	        credits: {
	            enabled: false
	        }
		});
	},

    destroy: function(){
      this._el.highcharts().destroy();
    },

    refresh: function(){
        this._el.highcharts().reflow();
    },

    _getCurrentDataPos: function(){
        var current_date = new Date();
        var pos = 0;

        for (var i in this._data.categories){
            var date = this._data.categories[i];

            pos ++;

            if(current_date.getMonth() + "/" + current_date.getFullYear() == date){
               return pos;
            }
        }

        return null;
    }
});