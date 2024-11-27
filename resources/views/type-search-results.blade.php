<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@7/themes/algolia-min.css">
<script async src="https://cdn.jsdelivr.net/npm/instantsearch.js@4.44.0"></script>
<script async
        src="https://cdn.jsdelivr.net/npm/typesense-instantsearch-adapter@2/dist/typesense-instantsearch-adapter.min.js"></script>

<title>Typesense InstantSearch.js Demo</title>

<div class="container">
    <div class="search-panel">
        <div class="search-panel__results">
            <div id="searchbox"></div>
            <div id="hits"></div>
        </div>
    </div>

    <div id="pagination"></div>
</div>

<script>
    const indexName = '{{ $indexName }}';
    const host = '{{ $host }}';
    const hostPort = '{{ $hostPort }}';
    const hostProtocol = '{{ $hostProtocol }}';
    const apiKey = '{{ $apiKey }}';

    const typesenseInstantSearchAdapter = new TypesenseInstantSearchAdapter({
        server: {
            apiKey: apiKey,
            nodes: [
                {
                    host: host,
                    port: hostPort,
                    protocol: hostProtocol,
                },
            ],
        },
        // The following parameters are directly passed to Typesense's search API endpoint.
        //  So you can pass any parameters supported by the search endpoint below.
        //  queryBy is required.
        //  filterBy is managed and overridden by InstantSearch.js. To set it, you want to use one of the filter widgets like refinementList or use the `configure` widget.
        additionalSearchParameters: {
            queryBy: 'title,authors',
        },
    });
    const searchClient = typesenseInstantSearchAdapter.searchClient;

    const search = instantsearch({searchClient, indexName: indexName,});

    search.addWidgets([
        instantsearch.widgets.searchBox({
            container: '#searchbox',
        }),
        instantsearch.widgets.configure({
            hitsPerPage: 8,
        }),
        instantsearch.widgets.hits({
            container: '#hits',
            templates: {
                item(item) {
                    return `
                        <div>
                          <img src="${item.image_url}" alt="${item.name}" height="100" />
                          <div class="hit-name">
                            ${item._highlightResult.title.value}
                          </div>
                          <div class="hit-authors">
                          ${item._highlightResult.authors.map((a) => a.value).join(', ')}
                          </div>
                          <div class="hit-publication-year">${item.publication_year}</div>
                          <div class="hit-rating">${item.average_rating}/5 rating</div>
                        </div>
                      `;
                },
            },
        }),
        instantsearch.widgets.pagination({
            container: '#pagination',
        }),
    ]);

    search.start();
</script>
