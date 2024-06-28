---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: default
---

<h1 id="page-title"></h1>

<ul id="gallery"></ul>




{% for item in site.collections %}
<div class="col-md-4">
 <div class="card mb-4 box-shadow">
  <h2><a href="{{site.url}}{{item.url}}">{{ item.title }}</a></h2>
  <p>{{ item.description }}</p>
  </div>
</div>
{% endfor %}
