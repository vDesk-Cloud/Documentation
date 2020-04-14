<?php use vDesk\Pages\Functions; ?>
<div>
    <h2>Custom releases</h2>
    <p>
        As of the modular approach of vDesk, the system is capable of creating custom packages as well as composing entire setups.<br>
        To enable bundling of packages and setups, you'll need to have the <a href="<?= Functions::URL("vDesk", "Page", "Packages#Packages") ?>">Packages</a> and <a
                href="<?= Functions::URL("vDesk", "Page", "Packages#Console") ?>">Console</a>-packages installed (both are bundled by default in the official full release).<br>
        Press <code class="Inline">° / Shift + ^</code> to open the client side console.
    </p>
    <h5>Example of creating custom setups</h5>
    <section style="text-align: center">
        <aside onclick="this.classList.toggle('Fullscreen')">
            <img
                    title="The output represents the list of packages that have been bundled into the setup."
                    class="CustomSetup"
                    src="<?= Functions::Image("Documentation/CustomSetup.png") ?>"
            >
        </aside>
    </section>
    <h3>Packages</h3>
    <p>To create a single custom package enter one of the following commands:</p>
    <pre><code><span class="Console">Call -M=Packages -C=CreatePackage -Package=Archive [-Path=C:\Users]
Call -Module=Packages -Command=CreatePackage -Package=Calendar [-Path=/home/user]</span></code></pre>
    <p>
        This will create a PHAR archive named like the specified package and bundled with the files and folders of the package at the optionally specified path on the server.<br>
        If you omit the "Path"-parameter, the setup file will be created in the systems Server directory.
    </p>

</div>
<h3>Setups</h3>
<p>To create a custom setup enter one of the following commands:</p>
<pre><code><span class="Console">Call -M=Packages -C=CreateSetup [-Path=E:\Development\Setups]
Call -Module=Packages -Command=CreateSetup [-Path=/var/www/htdocs/vDesk/Server]</span></code></pre>

<p>This will create a "Setup.phar"-file bundled with all currently installed packages at the optionally specified path on the server.</p>

<h4>Excluding packages</h4>
<p>
    If you want to exclude certain packages, you can optionally provide a comma separated list of packages that won't get bundled in the setup.
</p>
<pre><code><span class="Console">Call -M=Packages -C=CreateSetup [-Path=%TargetDir%] [-Exclude=Pages, Homepage, Documentation, ...]
Call -Module=Packages -Command=CreateSetup [-Path=%TargetDir%] [-Exclude=%A%, %B%, ...]</span></code></pre>
<p>
    Alternatively, you can provide a JSON array of packages.
</p>
<pre><code><span class="Console">Call -M=Packages -C=CreateSetup -Exclude=["Pages", "Homepage", "Documentation", "Contacts", "Messenger"]</span></code></pre>
