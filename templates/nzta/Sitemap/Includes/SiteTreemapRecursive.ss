<ul>
    <% loop $Parent %>
        <li>
			<a href="$Link"><% if $MenuTitle %>$MenuTitle<% else %>$Title<% end_if %></a>
            <% if $SitemapChildren %>
                <% include nzta/Sitemap/SitemapRecursive Parent=$SitemapChildren %>
            <% end_if %>
        </li>
    <% end_loop %>
</ul>
