var AppProductionMeta = Class.extend
({


    // Model.
    model:
    {
        iTunesLookup: "",
    },


    construct: function()
    { },

    removeDidClick: function(event)
    {
        var button = event.currentTarget;
        console.log(button.name+'.removeDidClick()');
    },

    addDidClick: function(event)
    {
        var button = event.currentTarget;
        console.log(button.name+'.addDidClick()');
    }

});

// Instantiate.
var appProductionMeta = new AppProductionMeta();