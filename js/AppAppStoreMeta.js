var AppAppStoreMeta = Class.extend
({


    // Model.
    model:
    {
        iTunesLookup: "",
    },


    construct: function()
    { },

    appIDchanged: function(event)
    {
        var value = event.currentTarget.value;
        var isAppID = /\b[0-9]{9}\b/.test(value);
        var not = (isAppID) ? "" : "not ";
        // console.log("`"+value+"` is "+not+"App ID.");

        // Only if App ID.
        if (isAppID == false) return;

        // Request.
        var url = 'https://itunes.apple.com/lookup?id='+value;
        // console.log(url);
        qwest.setDefaultDataType('json');
        qwest.get(url)
            .then(function(xhr, response)
            {
                appAppStoreMeta.model.iTunesLookup = JSON.parse(response).results[0];
                // console.log(appAppStoreMeta.model.iTunesLookup);
                appAppStoreMeta.update();

            })
            .catch(function(error, xhr, response)
            {
                // console.log(response);
                // console.log(error);
            })
            .complete(function()
            {
                // Always run.
            });
    },

    update: function()
    {
        jQuery("#app_appstore_trackCensoredName").attr(
            "value",
            this.model.iTunesLookup.trackCensoredName
        );

        jQuery("#app_appstore_trackViewUrl").attr(
            "value",
            this.model.iTunesLookup.trackViewUrl
        );

        jQuery("#app_appstore_artworkUrl512").attr(
            "value",
            this.model.iTunesLookup.artworkUrl512
        );

        jQuery("#app_appstore_icon").attr(
            "src",
            this.model.iTunesLookup.artworkUrl512
        );

        jQuery("#app_appstore_releaseDate").attr(
            "value",
            this.model.iTunesLookup.releaseDate
        );
    },

    inputDidDoubleClick: function(event)
    {
        var input = event.currentTarget;

        // Toggle.
        input.readOnly = !input.readOnly;
    }

});

// Instantiate.
var appAppStoreMeta = new AppAppStoreMeta();