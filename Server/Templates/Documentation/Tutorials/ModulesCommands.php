<?php
use vDesk\Documentation\Code;
use vDesk\Documentation\Code\Language;
use vDesk\Pages\Functions;
?>
<h2>Modules & Commands</h2>
<p>
    This tutorial complains about registering and executing Commands against modules of the server.
</p>
<hr>
<h3>
    Concept
</h3>
<p>
    From a global point of view, the application flow of vDesk can be described as a client/server "View-(Controller-Model)-system, where the client represents the "View",
    <br> whereas the server represents the "Controller"-host which manage the "Models".
</p>
<h4>Conceptual overview</h4>
<img alt="Conceptual description of vDesk's application flow" title="Conceptual description of vDesk's application flow" style="width: 100%" src="<?= Functions::Image("Documentation", "Concept.svg") ?>">
<hr>
<h3>Modules</h3>
<p>
    Modules are the controller-equivalent of MVC-frameworks.<br>
    The module-system of vDesk, is split into a server- and client-section.
</p>
<h4>Client</h4>
<p>
    Client-side Modules are supposed to manage the UI and fetching or manipulating data by executing Commands against the server.
</p>
<p>
    To register a class as a client-side Module, the class to be located in the <code class="Inline">Modules</code>-namespace<br> and must implement either the <code class="Inline">vDesk.Modules.<?= Code::Class("IModule") ?></code>- or <code class="Inline">vDesk.Modules.<?= Code::Class("IVisualModule") ?></code>-interface.
</p>
<h4>Server</h4>
<p>
    Server-side Modules are supposed to process commands, validate parameters and manage Models.
</p>
<p>
    To register a class as a server-side Module, the class has to be located in the <code class="Inline">Modules</code>-namespace and must inherit from the <code class="Inline">\vDesk\Modules\<?= Code::Class("Module") ?></code>-class.<br>
    The Module base-class implements the <code class="Inline">\vDesk\Data\<?= Code::Class("IModel") ?></code>-interface which allows to simply instantiate the Module once and call its "Save"-method to register it.<br>
    Modules are stored in the <code class="Inline">Modules.Modules</code>-table.
</p>
<hr>
<h3>Commands</h3>
<p>
    vDesk's public API is exposed via a collection of "Commands" which are stored in the database, each referencing a target module and method to execute, as well as describing the<br>
    Each Command references a target module and method to execute, as well as describing the parameters of the command.<br>
    Commands are stored in the <code class="Inline">Modules.Commands</code>-table.
</p>
<pre><code><?= Language::JS ?>
<?= Code::Variable("vDesk") ?>.<?= Code::Class("Connection") ?>.<?= Code::Function("Send") ?>(
    <?= Code::New ?> <?= Code::Variable("vDesk") ?>.<?= Code::Field("Modules") ?>.<?= Code::Class("Command") ?>(
        {
            <?= Code::Variable("Module") ?>:  <?= Code::String("\"Archive\"") ?>,
            <?= Code::Variable("Command") ?>: <?= Code::String("\"Upload\"") ?>,
            <?= Code::Variable("Parameters") ?>: {
                <?= Code::Variable("Parent") ?>: ParentElement,
                <?= Code::Variable("File") ?>:   File,
            },
            <?= Code::Variable("Ticket") ?>: <?= Code::Variable("vDesk") ?>.<?= Code::Field("User") ?>.<?= Code::Field("Ticket") ?>
        
        },
        Response => {
            <?= Code::If ?>(Response.<?= Code::Field("Status") ?>){
                <?= Code::Class("console") ?>.<?= Code::Function("log") ?>(Response.<?= Code::Field("Data") ?>)<?= Code::Delimiter ?>
        
            }
        }
    )
)<?= Code::Delimiter ?>
</code></pre>
<h4>Parameters</h4>
<p>
    Commands can require any parameters if needed, describing the name, type, nullabillity and optionality.<br>
    Parameters are stored in the <code class="Inline">Modules.Parameters</code>-table.
</p>
<pre><code><?= Language::PHP ?>
<?= Code::Use ?> vDesk\Modules\<?= Code::Class("Command") ?><?= Code::Delimiter ?>

<?= Code::Use ?> vDesk\Struct\Collections\Observable\<?= Code::Class("Collection") ?><?= Code::Delimiter ?>

        
<?= Code::Variable("\$Archive") ?> = \vDesk\<?= Code::Class("Modules") ?>::<?= Code::Function("Archive") ?>()<?= Code::Delimiter ?>


<?= Code::Variable("\$Archive") ?>-><?= Code::Field("Commands") ?>-><?= Code::Function("Add") ?>(
    <?= Code::New ?> <?= Code::Class("Command") ?>(
        <?= Code::Null ?>,
        <?= Code::Variable("\$Module") ?>,
        <?= Code::String("\"Upload\"") ?>,
        <?= Code::Bool("true") ?>,
        <?= Code::Bool("false") ?>,
        <?= Code::Null ?>,
        <?= Code::New ?> <?= Code::Class("Collection") ?>([
            <?= Code::New ?> <?= Code::Class("Parameter") ?>(<?= Code::Null ?>, <?= Code::Null ?>, <?= Code::String("\"Parent\"") ?>, <?= Code::Class("Type") ?>::<?= Code::Const("Int") ?>, <?= Code::Bool("false") ?>, <?= Code::Bool("false") ?>),
            <?= Code::New ?> <?= Code::Class("Parameter") ?>(<?= Code::Null ?>, <?= Code::Null ?>, <?= Code::String("\"File\"") ?>, \Extension\<?= Code::Class("Type") ?>::<?= Code::Const("File") ?>, <?= Code::Bool("false") ?>, <?= Code::Bool("false") ?>),
            <?= Code::New ?> <?= Code::Class("Parameter") ?>(<?= Code::Null ?>, <?= Code::Null ?>, <?= Code::String("\"Owner\"") ?>, \vDesk\Security\<?= Code::Class("User") ?>::<?= Code::Const("class") ?>, <?= Code::Bool("true") ?>, <?= Code::Bool("true") ?>)
        ])
    )
)<?= Code::Delimiter ?>


<?= Code::Variable("\$Module") ?>-><?= Code::Function("Save") ?>()<?= Code::Delimiter ?>
</code></pre>