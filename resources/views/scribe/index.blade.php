<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>MartaChef API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://MartaChef.test";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.0.1.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.0.1.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-POSTapi-register">
                                <a href="#endpoints-POSTapi-register">POST api/register</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-login">
                                <a href="#endpoints-POSTapi-login">POST api/login</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-posts">
                                <a href="#endpoints-GETapi-posts">GET api/posts</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-posts--id-">
                                <a href="#endpoints-GETapi-posts--id-">GET api/posts/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-posts">
                                <a href="#endpoints-POSTapi-posts">POST api/posts</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-posts--id-">
                                <a href="#endpoints-PUTapi-posts--id-">PUT api/posts/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-posts--id-">
                                <a href="#endpoints-DELETEapi-posts--id-">DELETE api/posts/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-myPosts">
                                <a href="#endpoints-GETapi-myPosts">GET api/myPosts</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-sharedPosts">
                                <a href="#endpoints-GETapi-sharedPosts">GET api/sharedPosts</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-users">
                                <a href="#endpoints-GETapi-users">GET api/users</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-users--id-">
                                <a href="#endpoints-GETapi-users--id-">GET api/users/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-users--user_id--follow">
                                <a href="#endpoints-POSTapi-users--user_id--follow">POST api/users/{user_id}/follow</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-users--user_id--unfollow">
                                <a href="#endpoints-POSTapi-users--user_id--unfollow">POST api/users/{user_id}/unfollow</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: February 22, 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://MartaChef.test</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-POSTapi-register">POST api/register</h2>

<p>
</p>



<span id="example-requests-POSTapi-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://MartaChef.test/api/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"b\",
    \"email\": \"zbailey@example.net\",
    \"password\": \"-0pBNvYgxw\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://MartaChef.test/api/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "b",
    "email": "zbailey@example.net",
    "password": "-0pBNvYgxw"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-register">
</span>
<span id="execution-results-POSTapi-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-register" data-method="POST"
      data-path="api/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-register"
                    onclick="tryItOut('POSTapi-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-register"
                    onclick="cancelTryOut('POSTapi-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-register"
               value="b"
               data-component="body">
    <br>
<p>El campo value no debe ser mayor que 255 caracteres. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-register"
               value="zbailey@example.net"
               data-component="body">
    <br>
<p>El campo value no es un correo válido. El campo value no debe ser mayor que 255 caracteres. Example: <code>zbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-register"
               value="-0pBNvYgxw"
               data-component="body">
    <br>
<p>El campo value debe contener al menos 8 caracteres. Example: <code>-0pBNvYgxw</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-login">POST api/login</h2>

<p>
</p>



<span id="example-requests-POSTapi-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://MartaChef.test/api/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://MartaChef.test/api/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-login">
</span>
<span id="execution-results-POSTapi-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-login" data-method="POST"
      data-path="api/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-login"
                    onclick="tryItOut('POSTapi-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-login"
                    onclick="cancelTryOut('POSTapi-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-posts">GET api/posts</h2>

<p>
</p>



<span id="example-requests-GETapi-posts">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://MartaChef.test/api/posts" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://MartaChef.test/api/posts"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-posts">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 2,
            &quot;title&quot;: &quot;Tarta de Fresas&quot;,
            &quot;description&quot;: &quot;Tarta con base de galleta y fresas frescas.&quot;,
            &quot;ingredients&quot;: &quot;Galletas, Mantequilla, Fresas, Crema Pastelera&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Paqui&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;2: Tartas&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Fresas #Tarta #Galletas #Cremapastelera #Verano #Postre #Sencillo&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 3,
            &quot;title&quot;: &quot;Tarta de Manzana&quot;,
            &quot;description&quot;: &quot;Tarta tradicional de manzana con una base crujiente y relleno jugoso, ideal para el t&eacute;.&quot;,
            &quot;ingredients&quot;: &quot;Manzanas, Masa quebrada, Az&uacute;car, Canela, Mantequilla, Huevo, Lim&oacute;n&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/pastel.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Paqui&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;2: Tartas&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Postre #Fruta #F&aacute;cil #Tradicional&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 5,
            &quot;title&quot;: &quot;Cupcakes de Vainilla&quot;,
            &quot;description&quot;: &quot;Peque&ntilde;os bizcochos esponjosos con un suave sabor a vainilla, perfectos para decorar.&quot;,
            &quot;ingredients&quot;: &quot;Harina, Az&uacute;car, Mantequilla, Huevo, Esencia de vainilla, Polvo de hornear, Leche&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/pastel.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Paqui&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;4: Cupcakes&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Vainilla #Suave #Postre #Fiesta&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 6,
            &quot;title&quot;: &quot;Galletas de Avena y Pasas&quot;,
            &quot;description&quot;: &quot;Galletas crujientes con avena y pasas, una combinaci&oacute;n saludable y deliciosa.&quot;,
            &quot;ingredients&quot;: &quot;Avena, Pasas, Harina, Mantequilla, Az&uacute;car moreno, Huevo, Polvo de hornear&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Paqui&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;5: Galletas&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Saludable #Avena #Dulce #F&aacute;cil&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 7,
            &quot;title&quot;: &quot;Pastel de Zanahoria&quot;,
            &quot;description&quot;: &quot;Un pastel h&uacute;medo y esponjoso con zanahorias, nueces y cubierto con un glaseado de queso crema.&quot;,
            &quot;ingredients&quot;: &quot;Zanahorias, Harina, Az&uacute;car, Nueces, Huevo, Aceite, Especias, Queso crema&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/pastel.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Paqui&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;1: Pasteles&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Saludable #Especias #Dulce #F&aacute;cil&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 9,
            &quot;title&quot;: &quot;Pudin de Ch&iacute;a y Cacao&quot;,
            &quot;description&quot;: &quot;Un postre saludable y f&aacute;cil de hacer, ideal para las tardes de verano.&quot;,
            &quot;ingredients&quot;: &quot;Semillas de ch&iacute;a, Cacao en polvo, Leche de almendra, Miel&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/pastel.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Paqui&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;10: Postres Saludables&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Saludable #Vegano #Cacao #R&aacute;pido&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 11,
            &quot;title&quot;: &quot;Galletas de Chocolate Chips&quot;,
            &quot;description&quot;: &quot;Galletas crujientes por fuera y suaves por dentro, con chips de chocolate.&quot;,
            &quot;ingredients&quot;: &quot;Harina, Az&uacute;car, Mantequilla, Chocolate, Huevo, Polvo de hornear&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Paqui&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;5: Galletas&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Chocolate #R&aacute;pido #Crujiente #Postre&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 16,
            &quot;title&quot;: &quot;Bizcocho de Yogur&quot;,
            &quot;description&quot;: &quot;Bizcocho f&aacute;cil de hacer con la receta del yogurt como medida.&quot;,
            &quot;ingredients&quot;: &quot;Yogur natural, Az&uacute;car, Huevo, Harina, Aceite, Levadura&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;Antonio&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;6: Bizcochos&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#F&aacute;cil #Esponjoso #B&aacute;sico #Dulce&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 17,
            &quot;title&quot;: &quot;Tarta de Queso al Horno&quot;,
            &quot;description&quot;: &quot;Deliciosa tarta de queso con una base crujiente y un relleno cremoso.&quot;,
            &quot;ingredients&quot;: &quot;Queso crema, Huevos, Az&uacute;car, Galletas, Mantequilla&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;Antonio&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;2: Tartas&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Queso #Horneado #Cremoso #Postre&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 20,
            &quot;title&quot;: &quot;Pastelitos de Naranja y Almendra&quot;,
            &quot;description&quot;: &quot;Pastelitos arom&aacute;ticos con un toque de naranja y almendra, perfectos para cualquier ocasi&oacute;n.&quot;,
            &quot;ingredients&quot;: &quot;Almendra molida, Naranja, Harina, Az&uacute;car, Huevo, Mantequilla&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;Antonio&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;1: Pasteles&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Naranja #Almendra #Arom&aacute;tico #Dulce&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 22,
            &quot;title&quot;: &quot;Galletas de Mantequilla&quot;,
            &quot;description&quot;: &quot;Galletas cl&aacute;sicas de mantequilla con un sabor suave y textura crujiente.&quot;,
            &quot;ingredients&quot;: &quot;Mantequilla, Az&uacute;car, Harina, Huevo, Esencia de vainilla&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;Antonio&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;5: Galletas&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Mantequilla #Cl&aacute;sicas #F&aacute;cil #Dulce&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 25,
            &quot;title&quot;: &quot;Bizcocho de Caf&eacute;&quot;,
            &quot;description&quot;: &quot;Bizcocho con un toque de caf&eacute; que lo convierte en el acompa&ntilde;ante perfecto para el desayuno.&quot;,
            &quot;ingredients&quot;: &quot;Caf&eacute;, Harina, Az&uacute;car, Huevo, Mantequilla&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 2,
                &quot;name&quot;: &quot;Antonio&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;6: Bizcochos&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Caf&eacute; #Energ&eacute;tico #Dulce #Desayuno&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 26,
            &quot;title&quot;: &quot;Tiramisu&quot;,
            &quot;description&quot;: &quot;Postre italiano con capas de bizcocho empapado en caf&eacute; y mascarpone cremoso.&quot;,
            &quot;ingredients&quot;: &quot;Mascarpone, Caf&eacute;, Bizcochos de soletilla, Cacao en polvo, Az&uacute;car, Huevo&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;Maria&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;11: Reposteria Internacional&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Italiano #Caf&eacute; #Cremoso #Dulce&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 27,
            &quot;title&quot;: &quot;Barras de Granola Caseras&quot;,
            &quot;description&quot;: &quot;Deliciosas barras de granola crujiente y saludable, perfectas para un snack r&aacute;pido.&quot;,
            &quot;ingredients&quot;: &quot;Avena, Frutos secos, Miel, Az&uacute;car, Mantequilla, Chocolate (opcional)&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;Maria&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;10: Postres Saludables&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Saludable #Snack #Crujiente #F&aacute;cil&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 29,
            &quot;title&quot;: &quot;Galletas de Lim&oacute;n y Jengibre&quot;,
            &quot;description&quot;: &quot;Galletas con un toque c&iacute;trico de lim&oacute;n y el sabor picante del jengibre.&quot;,
            &quot;ingredients&quot;: &quot;Lim&oacute;n, Jengibre, Az&uacute;car, Mantequilla, Harina, Huevo&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;Maria&quot;
            },
            &quot;categories&quot;: [],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Lim&oacute;n #Jengibre #C&iacute;trico #Dulce&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 31,
            &quot;title&quot;: &quot;Mousse de Chocolate&quot;,
            &quot;description&quot;: &quot;Un postre ligero y esponjoso con un intenso sabor a chocolate.&quot;,
            &quot;ingredients&quot;: &quot;Chocolate, Nata, Az&uacute;car, Huevo, Vainilla&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;Maria&quot;
            },
            &quot;categories&quot;: [],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Chocolate #Cremoso #Ligero #R&aacute;pido&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 33,
            &quot;title&quot;: &quot;Eclairs de Chocolate&quot;,
            &quot;description&quot;: &quot;Deliciosos profiteroles alargados rellenos de crema pastelera y cubiertos con chocolate.&quot;,
            &quot;ingredients&quot;: &quot;Harina, Huevos, Mantequilla, Leche, Az&uacute;car, Chocolate, Crema pastelera&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;Maria&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;11: Reposteria Internacional&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Eclairs #Chocolate #Pasteler&iacute;a #Cremapastelera #Dulce&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 34,
            &quot;title&quot;: &quot;Donas Glaseadas&quot;,
            &quot;description&quot;: &quot;Cl&aacute;sicas donas esponjosas fritas y cubiertas con un glaseado dulce.&quot;,
            &quot;ingredients&quot;: &quot;Harina, Az&uacute;car, Levadura, Leche, Huevos, Mantequilla, Esencia de vainilla&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;Maria&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;9: Postres Fritos&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Donas #Glaseado #Esponjoso #Casero #Dulce&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 35,
            &quot;title&quot;: &quot;Macarons de Frambuesa&quot;,
            &quot;description&quot;: &quot;Galletas francesas de almendra con relleno cremoso de frambuesa.&quot;,
            &quot;ingredients&quot;: &quot;Harina de almendra, Az&uacute;car glas, Claras de huevo, Frambuesas, Chocolate blanco&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;David&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;11: Reposteria Internacional&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Macarons #Frambuesa #Pasteler&iacute;a #Delicado #Colorido&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 36,
            &quot;title&quot;: &quot;Chocotorta Argentina&quot;,
            &quot;description&quot;: &quot;Postre argentino sin horno hecho con capas de galletas de chocolate y crema de dulce de leche.&quot;,
            &quot;ingredients&quot;: &quot;Galletas de chocolate, Dulce de leche, Queso crema, Caf&eacute;&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;David&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;11: Reposteria Internacional&quot;
                },
                {
                    &quot;category&quot;: &quot;12: Postres Sin Horno&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Chocotorta #Sinhorno #Argentino #Dulcedeleche #F&aacute;cil&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 38,
            &quot;title&quot;: &quot;Baklava de Pistacho&quot;,
            &quot;description&quot;: &quot;Dulce t&iacute;pico del Medio Oriente hecho con capas de masa filo, miel y pistachos.&quot;,
            &quot;ingredients&quot;: &quot;Masa filo, Pistachos, Miel, Az&uacute;car, Mantequilla&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;David&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;11: Reposteria Internacional&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Baklava #Pistacho #Dulceoriental #Crujiente #Casero&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 39,
            &quot;title&quot;: &quot;Helado Casero de Vainilla&quot;,
            &quot;description&quot;: &quot;Cremoso y delicioso helado casero con un intenso sabor a vainilla.&quot;,
            &quot;ingredients&quot;: &quot;Leche, Nata, Az&uacute;car, Yemas de huevo, Esencia de vainilla&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;David&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;13: Postres Fr&iacute;os&quot;
                },
                {
                    &quot;category&quot;: &quot;14: Helado&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Helado #Vainilla #Casero #F&aacute;cil #Refrescante&quot;
                }
            ]
        },
        {
            &quot;id&quot;: 40,
            &quot;title&quot;: &quot;Panettone Italiano&quot;,
            &quot;description&quot;: &quot;Pan dulce esponjoso con frutas confitadas y pasas, tradicional en Navidad.&quot;,
            &quot;ingredients&quot;: &quot;Harina, Levadura, Az&uacute;car, Mantequilla, Huevo, Pasas, Frutas confitadas&quot;,
            &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
            &quot;visibility&quot;: &quot;public&quot;,
            &quot;user&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;David&quot;
            },
            &quot;categories&quot;: [
                {
                    &quot;category&quot;: &quot;8: Panes Dulces&quot;
                },
                {
                    &quot;category&quot;: &quot;11: Reposteria Internacional&quot;
                }
            ],
            &quot;tags&quot;: [
                {
                    &quot;name&quot;: &quot;#Panettone #Italiano #Navide&ntilde;o #Esponjoso #Dulce&quot;
                }
            ]
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-posts" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-posts"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-posts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-posts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-posts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-posts" data-method="GET"
      data-path="api/posts"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-posts', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-posts"
                    onclick="tryItOut('GETapi-posts');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-posts"
                    onclick="cancelTryOut('GETapi-posts');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-posts"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/posts</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-posts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-posts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-posts--id-">GET api/posts/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-posts--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://MartaChef.test/api/posts/2" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://MartaChef.test/api/posts/2"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-posts--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 2,
        &quot;title&quot;: &quot;Tarta de Fresas&quot;,
        &quot;description&quot;: &quot;Tarta con base de galleta y fresas frescas.&quot;,
        &quot;ingredients&quot;: &quot;Galletas, Mantequilla, Fresas, Crema Pastelera&quot;,
        &quot;image&quot;: &quot;http://MartaChef.test/storage/images/tarta-fresas.png&quot;,
        &quot;visibility&quot;: &quot;public&quot;,
        &quot;user&quot;: {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Paqui&quot;
        },
        &quot;categories&quot;: [
            {
                &quot;category&quot;: &quot;2: Tartas&quot;
            }
        ],
        &quot;tags&quot;: [
            {
                &quot;name&quot;: &quot;#Fresas #Tarta #Galletas #Cremapastelera #Verano #Postre #Sencillo&quot;
            }
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-posts--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-posts--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-posts--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-posts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-posts--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-posts--id-" data-method="GET"
      data-path="api/posts/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-posts--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-posts--id-"
                    onclick="tryItOut('GETapi-posts--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-posts--id-"
                    onclick="cancelTryOut('GETapi-posts--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-posts--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/posts/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-posts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-posts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-posts--id-"
               value="2"
               data-component="url">
    <br>
<p>The ID of the post. Example: <code>2</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-posts">POST api/posts</h2>

<p>
</p>



<span id="example-requests-POSTapi-posts">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://MartaChef.test/api/posts" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "title=b"\
    --form "description=Eius et animi quos velit et."\
    --form "ingredients=architecto"\
    --form "visibility=shared"\
    --form "tags=architecto"\
    --form "image=@C:\Users\Usuario\AppData\Local\Temp\php16F0.tmp" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://MartaChef.test/api/posts"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('title', 'b');
body.append('description', 'Eius et animi quos velit et.');
body.append('ingredients', 'architecto');
body.append('visibility', 'shared');
body.append('tags', 'architecto');
body.append('image', document.querySelector('input[name="image"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-posts">
</span>
<span id="execution-results-POSTapi-posts" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-posts"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-posts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-posts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-posts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-posts" data-method="POST"
      data-path="api/posts"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-posts', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-posts"
                    onclick="tryItOut('POSTapi-posts');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-posts"
                    onclick="cancelTryOut('POSTapi-posts');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-posts"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/posts</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-posts"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-posts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="POSTapi-posts"
               value="b"
               data-component="body">
    <br>
<p>El campo value no debe ser mayor que 255 caracteres. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="POSTapi-posts"
               value="Eius et animi quos velit et."
               data-component="body">
    <br>
<p>Example: <code>Eius et animi quos velit et.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ingredients</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ingredients"                data-endpoint="POSTapi-posts"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>visibility</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="visibility"                data-endpoint="POSTapi-posts"
               value="shared"
               data-component="body">
    <br>
<p>Example: <code>shared</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>public</code></li> <li><code>private</code></li> <li><code>shared</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>categories</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="categories[0]"                data-endpoint="POSTapi-posts"
               data-component="body">
        <input type="text" style="display: none"
               name="categories[1]"                data-endpoint="POSTapi-posts"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the categories table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>tags</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="tags"                data-endpoint="POSTapi-posts"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>image</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="image"                data-endpoint="POSTapi-posts"
               value=""
               data-component="body">
    <br>
<p>El campo value debe ser una imagen. Example: <code>C:\Users\Usuario\AppData\Local\Temp\php16F0.tmp</code></p>
        </div>
        </form>

                    <h2 id="endpoints-PUTapi-posts--id-">PUT api/posts/{id}</h2>

<p>
</p>



<span id="example-requests-PUTapi-posts--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://MartaChef.test/api/posts/2" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "title=b"\
    --form "description=Eius et animi quos velit et."\
    --form "ingredients=architecto"\
    --form "visibility=shared"\
    --form "tags=architecto"\
    --form "image=@C:\Users\Usuario\AppData\Local\Temp\php172F.tmp" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://MartaChef.test/api/posts/2"
);

const headers = {
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('title', 'b');
body.append('description', 'Eius et animi quos velit et.');
body.append('ingredients', 'architecto');
body.append('visibility', 'shared');
body.append('tags', 'architecto');
body.append('image', document.querySelector('input[name="image"]').files[0]);

fetch(url, {
    method: "PUT",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-posts--id-">
</span>
<span id="execution-results-PUTapi-posts--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-posts--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-posts--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-posts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-posts--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-posts--id-" data-method="PUT"
      data-path="api/posts/{id}"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-posts--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-posts--id-"
                    onclick="tryItOut('PUTapi-posts--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-posts--id-"
                    onclick="cancelTryOut('PUTapi-posts--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-posts--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/posts/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-posts--id-"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-posts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-posts--id-"
               value="2"
               data-component="url">
    <br>
<p>The ID of the post. Example: <code>2</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>title</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="title"                data-endpoint="PUTapi-posts--id-"
               value="b"
               data-component="body">
    <br>
<p>El campo value no debe ser mayor que 255 caracteres. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="PUTapi-posts--id-"
               value="Eius et animi quos velit et."
               data-component="body">
    <br>
<p>Example: <code>Eius et animi quos velit et.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ingredients</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ingredients"                data-endpoint="PUTapi-posts--id-"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>visibility</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="visibility"                data-endpoint="PUTapi-posts--id-"
               value="shared"
               data-component="body">
    <br>
<p>Example: <code>shared</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>public</code></li> <li><code>private</code></li> <li><code>shared</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>categories</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="categories[0]"                data-endpoint="PUTapi-posts--id-"
               data-component="body">
        <input type="text" style="display: none"
               name="categories[1]"                data-endpoint="PUTapi-posts--id-"
               data-component="body">
    <br>
<p>The <code>id</code> of an existing record in the categories table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>tags</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="tags"                data-endpoint="PUTapi-posts--id-"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>image</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="image"                data-endpoint="PUTapi-posts--id-"
               value=""
               data-component="body">
    <br>
<p>El campo value debe ser una imagen. Example: <code>C:\Users\Usuario\AppData\Local\Temp\php172F.tmp</code></p>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-posts--id-">DELETE api/posts/{id}</h2>

<p>
</p>



<span id="example-requests-DELETEapi-posts--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://MartaChef.test/api/posts/2" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://MartaChef.test/api/posts/2"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-posts--id-">
</span>
<span id="execution-results-DELETEapi-posts--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-posts--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-posts--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-posts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-posts--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-posts--id-" data-method="DELETE"
      data-path="api/posts/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-posts--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-posts--id-"
                    onclick="tryItOut('DELETEapi-posts--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-posts--id-"
                    onclick="cancelTryOut('DELETEapi-posts--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-posts--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/posts/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-posts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-posts--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-posts--id-"
               value="2"
               data-component="url">
    <br>
<p>The ID of the post. Example: <code>2</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-myPosts">GET api/myPosts</h2>

<p>
</p>



<span id="example-requests-GETapi-myPosts">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://MartaChef.test/api/myPosts" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://MartaChef.test/api/myPosts"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-myPosts">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-myPosts" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-myPosts"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-myPosts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-myPosts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-myPosts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-myPosts" data-method="GET"
      data-path="api/myPosts"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-myPosts', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-myPosts"
                    onclick="tryItOut('GETapi-myPosts');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-myPosts"
                    onclick="cancelTryOut('GETapi-myPosts');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-myPosts"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/myPosts</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-myPosts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-myPosts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-sharedPosts">GET api/sharedPosts</h2>

<p>
</p>



<span id="example-requests-GETapi-sharedPosts">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://MartaChef.test/api/sharedPosts" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://MartaChef.test/api/sharedPosts"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-sharedPosts">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-sharedPosts" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-sharedPosts"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-sharedPosts"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-sharedPosts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-sharedPosts">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-sharedPosts" data-method="GET"
      data-path="api/sharedPosts"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-sharedPosts', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-sharedPosts"
                    onclick="tryItOut('GETapi-sharedPosts');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-sharedPosts"
                    onclick="cancelTryOut('GETapi-sharedPosts');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-sharedPosts"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/sharedPosts</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-sharedPosts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-sharedPosts"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-users">GET api/users</h2>

<p>
</p>



<span id="example-requests-GETapi-users">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://MartaChef.test/api/users" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://MartaChef.test/api/users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-users">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-users" data-method="GET"
      data-path="api/users"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-users"
                    onclick="tryItOut('GETapi-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-users"
                    onclick="cancelTryOut('GETapi-users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-users"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/users</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-users--id-">GET api/users/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-users--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://MartaChef.test/api/users/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://MartaChef.test/api/users/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-users--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-users--id-" data-method="GET"
      data-path="api/users/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-users--id-"
                    onclick="tryItOut('GETapi-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-users--id-"
                    onclick="cancelTryOut('GETapi-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-users--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/users/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-users--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the user. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-users--user_id--follow">POST api/users/{user_id}/follow</h2>

<p>
</p>



<span id="example-requests-POSTapi-users--user_id--follow">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://MartaChef.test/api/users/1/follow" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://MartaChef.test/api/users/1/follow"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-users--user_id--follow">
</span>
<span id="execution-results-POSTapi-users--user_id--follow" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-users--user_id--follow"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users--user_id--follow"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-users--user_id--follow" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users--user_id--follow">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-users--user_id--follow" data-method="POST"
      data-path="api/users/{user_id}/follow"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-users--user_id--follow', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-users--user_id--follow"
                    onclick="tryItOut('POSTapi-users--user_id--follow');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-users--user_id--follow"
                    onclick="cancelTryOut('POSTapi-users--user_id--follow');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-users--user_id--follow"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/users/{user_id}/follow</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-users--user_id--follow"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-users--user_id--follow"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user_id"                data-endpoint="POSTapi-users--user_id--follow"
               value="1"
               data-component="url">
    <br>
<p>The ID of the user. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-users--user_id--unfollow">POST api/users/{user_id}/unfollow</h2>

<p>
</p>



<span id="example-requests-POSTapi-users--user_id--unfollow">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://MartaChef.test/api/users/1/unfollow" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://MartaChef.test/api/users/1/unfollow"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-users--user_id--unfollow">
</span>
<span id="execution-results-POSTapi-users--user_id--unfollow" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-users--user_id--unfollow"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users--user_id--unfollow"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-users--user_id--unfollow" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users--user_id--unfollow">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-users--user_id--unfollow" data-method="POST"
      data-path="api/users/{user_id}/unfollow"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-users--user_id--unfollow', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-users--user_id--unfollow"
                    onclick="tryItOut('POSTapi-users--user_id--unfollow');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-users--user_id--unfollow"
                    onclick="cancelTryOut('POSTapi-users--user_id--unfollow');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-users--user_id--unfollow"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/users/{user_id}/unfollow</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-users--user_id--unfollow"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-users--user_id--unfollow"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user_id"                data-endpoint="POSTapi-users--user_id--unfollow"
               value="1"
               data-component="url">
    <br>
<p>The ID of the user. Example: <code>1</code></p>
            </div>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
