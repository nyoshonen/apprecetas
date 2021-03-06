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
<h2>Explicación</h2>
<p>He elegido Slim Framework 3 (pese no haberlo utilizado nunca anteriormente) por sus características, ya que permite realizar API Rest de forma rápida, tests automáticos y su curva de aprendizaje es rápida.</p>
<p>He creado tests automáticos (con PHPUnit) y el Frontend (APP mediante templates basadas en twig-view) para probar cada uno de los métodos de inserción, modificación, eliminación y en el caso de los platos, la opción de clonar (BONUS), es decir, hacer una réplica del plato con sus ingredientes y acto seguido se puede modificar su nombre e ingredientes (añade al final del nombre del plato " (copia)".</p>
<h2>Configuración en Windows</h2>
<p>C:\Windows\System32\drivers\etc\hosts</p>
<p><strong>127.0.0.1	apprecetas</strong></p>
<h2>Configuración en XAMPP</h2>
<p>C:\xampp\apache\conf\extra\httpd-vhosts.conf</p>
<pre>
&lt;VirtualHost *:80&gt;
  DocumentRoot "C:/xampp/htdocs/apprecetas/public"
  ServerName apprecetas
&lt;/VirtualHost&gt;
</pre>
<h2>Datos de Conexión a la Base de Datos</h2>
<p>/app/settings.php</p>
<h2>Estructura de las Tablas de la Base de Datos</h2>
<p>/sql/db_recetas.sql</p>
<h2>TESTS</h2>
<p>phpunit tests/ApiTest.php</p>
<h2>APP</h2>
<p>http://apprecetas/app</p>
