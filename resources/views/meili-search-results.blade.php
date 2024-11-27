<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@7/themes/algolia-min.css"/>
<style>
    body {
        font-family: sans-serif;
        padding: 1em;
    }

    body,
    h1 {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica,
        Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    }


    .ais-ClearRefinements {
        margin: 1em 0;
    }

    .ais-SearchBox {
        margin: 1em 0;
    }

    .ais-Pagination {
        margin-top: 1em;
    }

    .left-panel {
        float: left;
        width: 200px;
    }

    .right-panel {
        margin-left: 210px;
    }

    .ais-InstantSearch {
        max-width: 960px;
        overflow: hidden;
        margin: 0 auto;
    }

    .ais-Hits-item {
        margin-bottom: 1em;
        width: calc(50% - 1rem);
    }

    .ais-Hits-item img {
        margin-right: 1em;
        width: 100%;
        height: 100%;
        margin-bottom: 0.5em;
    }

    .hit-name {
        margin-bottom: 0.5em;
    }

    .hit-description {
        font-size: 90%;
        margin-bottom: 0.5em;
        color: grey;
    }

    .hit-info {
        font-size: 90%;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/instantsearch.js@4"></script>
<script src="https://cdn.jsdelivr.net/npm/@meilisearch/instant-meilisearch/dist/instant-meilisearch.umd.min.js"></script>

<div class="left-panel">
    <div id="clear-refinements"></div>

    <h2>Genres</h2>
    <div id="genres-list"></div>
    <h2>Categories</h2>
    <div id="categories-list"></div>
    <h2>Platforms</h2>
    <div id="platforms-list"></div>
</div>

<div class="right-panel">
    <div id="searchbox" class="ais-SearchBox"></div>
    <div id="hits"></div>
    <div id="pagination"></div>
</div>

<script>
    const indexName = '{{ $indexName }}';
    const hostUrl = '{{ $hostUrl }}';
    const apiKey = '{{ $apiKey }}';

    const search = instantsearch({
        indexName: indexName,
        routing: true,
        searchClient: instantMeiliSearch(hostUrl, apiKey, {finitePagination: true}).searchClient,
    });

    search.addWidgets([
        instantsearch.widgets.searchBox({
            container: "#searchbox",
        }),
        instantsearch.widgets.clearRefinements({
            container: "#clear-refinements",
        }),
        instantsearch.widgets.refinementList({
            container: "#genres-list",
            attribute: "genres",
        }),
        instantsearch.widgets.refinementList({
            container: "#categories-list",
            attribute: "categories",
        }),
        instantsearch.widgets.refinementList({
            container: "#platforms-list",
            attribute: "platforms",
        }),
        instantsearch.widgets.configure({
            hitsPerPage: 6,
            snippetEllipsisText: "...",
            attributesToSnippet: ["description:50"],
        }),
        instantsearch.widgets.hits({
            container: "#hits",
            templates: {
                item: `
        <div>
          <div class="hit-name">
            @{{#helpers.highlight}}{ "attribute": "name" }@{{/helpers.highlight}}
                </div>
                <img src="@{{image}}" align="left" />
          <div class="hit-description">
            @{{#helpers.snippet}}{ "attribute": "description" }@{{/helpers.snippet}}
                </div>
                <div class="hit-info">price: @{{price}}</div>
          <div class="hit-info">release date: @{{releaseDate}}</div>
        </div>
      `,
            },
        }),
        instantsearch.widgets.pagination({
            container: "#pagination",
        }),
    ]);
    search.start();
</script>
