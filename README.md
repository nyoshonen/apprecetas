<h1>PHP: API Rest - APP</h1>
<p>Debido a una nueva legislación, los restaurantes necesitan tener información disponible acerca de los alérgenos que tiene cada plato que sirven.<br>Un plato tiene varios ingredientes, y un ingrediente puede tener varios alérgenos.</p>
<p>Un restaurante ha contratado una aplicación movil que gestione para sus camareros cualquier duda de los clientes acerca de esta materia.<br>La implementación de dicha app nos es transparente, salvo porque hace uso de una API Rest que le servirá la información que necesita.</p>
<p>Implementa un pequeño sistema que se componga de:</p>
<ul>
  <li>Una base de datos que almacene los platos y sus alérgenos.</li>
  <li>Una API Rest que devuelva los alérgenos de un plato dado, o los platos en los que aparece un alérgeno concreto, y permita añadir ingredientes, platos y alérgenos.</li>
</ul>
<p>(No será necesario un sistema de usuarios ni roles)</p>
<p>Bonus: Supongamos que un cocinero puede realizar cambios sobre los ingredientes de un plato. Diseña y, si puedes, implementa un sistema para que quede un registro de cambios sobre los platos.</p>
<hr>
<p>He elegido Slim Framework 3 por su facilidad para la creación de API Rest y este tipo de ejercicios.</p>
<p>Además he creado tests automáticos (con PHPUnit) y el Frontend (app) para probar cada uno de los métodos de inserción, modificación, eliminación y en el caso de los platos, la opción de clonar, es decir, hace una réplica del plato con sus ingredientes y acto seguido se puede modificar su nombre e ingredientes (añade al final del nombre del plato la coletilla " (copia)".</p>
<h2>Configuración en Windows:</h2>
<p>C:\Windows\System32\drivers\etc\hosts</p>
<p><strong>127.0.0.1	apprecetas</strong></p>
<h2>Configuración en XAMPP:</h2>
<p>C:\xampp\apache\conf\extra\httpd-vhosts.conf</p>
<pre>
&lt;VirtualHost *:80&gt;
  DocumentRoot "C:/xampp/htdocs/apprecetas/public"
  ServerName apprecetas
&lt;/VirtualHost&gt;
</pre>
<h2>URL de la APP:</h2>
<p>http://apprecetas/app</p>
