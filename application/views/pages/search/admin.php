<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Search Admin</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <p class="lead">Console</p>
            <?php if($indexed) {
                echo "<p id='logstring'>An index exists.<br /></p>";
            } else {
                echo "<p id='logstring'>This site has not been indexed.<br /></p>";
            }?>
        </div>
        <div class="col-md-9">
            <form>
                <p class="lead">Index Map</p>
                <textarea class="form-control" id="map" rows="25">
{
    "pages": {
        "home": {
            regions: "the, ids, you, want, tomake, searchable"
        }
    },
    "tables": {
        "posts": {
            "title_field":"title",
            "slug_field":"post_id",
            "fields": "fields,youwant,tosearch",
            "url_pattern": "/blog/post/~SLUG~"
        }
    }
}
                </textarea>
                <div class="input-group">
                    Auto-Index Pages:  <input type="checkbox" id="autoMap" />
                </div>
                <div class="warning-box">
                    
                </div>
                <input type="button" class="btn btn-default" id="doIndex" value="Run Indexer" />
            </form>
        </div>
    </div>
</div>