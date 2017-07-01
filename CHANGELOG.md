# twentyseventeen-devtimes

* 0.3.0

    + Built `AppAppStore` meta box
        + `AppAppStore.MetaBox.twig`
        + `App.scss`
        + Enqueue admin styles in `functions.php`

* 0.2.3

    + `design` files
    + Renamed model files
        + `AppDetails` are `AppAppStore`
        + `AppProject` are `AppProduction`
    + `Meta` now have `fallback_id_`
    + Added error logging (with `.gitignore`)
    + `css` folder for `scss` assets

* 0.2.2

    + Put twig templates to `templates`
    
* 0.2.1

    + Removed `key` from `Meta`  
        + Use `id` directly
    + Save properties each (instead of a single array)
        + Only public properties get saved 

* 0.1.0

    + Enqueue admin scripts 
    + iTunes API hookup
        + Lookup using Affilate API
        + Store some relevant field in `AppDetailsMeta`
        + Updated in excerpt template

* 0.0.8

    + Extracted post meta features
        + Wordpress related stuff gone to `Meta` class
        + Actual model implementations can extend `Meta`
            + See `AppDetailsMeta`
            + See `AppProjectMeta`            

* 0.0.4 - 0.0.5

    + Renamings
    + Meta model extracted to `AppMeta` class
        + Meta(box) features should slowly moved down there

* 0.0.3

    + Custom post type "App" is up and running
    + Meta box is hooked up
    + Twig templates are in
    + Index template lists "App" entries

* 0.0.1 - 0.0.2

    + Prototype

* 0.0.0

    + Initial commit