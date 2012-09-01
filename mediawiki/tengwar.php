<?php

$wgHooks["ParserFirstCallInit"][] = "wfTengwarInit";

function wfTengwarInit(Parser $parser) {
    $parser->setHook("tengwar", "wfTengwar");
    $parser->setHook("tengwarblock", "wfTengwarBlock");
    return true;
}

function wfTengwar($input, array $args) {
    return wfMakeTengwar($input, $args, "span");
}

function wfTengwarBlock($input, array $args) {
    return wfMakeTengwar($input, $args, "div");
}

function wfMakeTengwar($input, array $args, $tag) {
    $encoded = array_key_exists("encoded", $args) ? $args["encoded"] : "";
    $bindings = array_key_exists("bindings", $args) ? $args["bindings"] : "(JavaScript required)";
    $mode = $args["mode"];
    if ($mode != "general-use" && $mode != "classical") {
        $mode = "general-use";
    }
    $font = $args["font"];
    if ($font != "parmaite" && $font != "annatar") {
        $font = "parmiate";
    }
    return array(
        "<" . $tag . " class=\"tengwar $font\"" .
        ( $input ? " data-tengwar=\"" .  htmlspecialchars($input) . "\"" : "" ) .
        ( $encoded ? " data-encoded=\"" .  htmlspecialchars($encoded) . "\"" : "" ) .
        ( $mode ? " data-mode=\"$mode\"" : "" ) .
        ">" .  htmlspecialchars($bindings) .  "</" . $tag . ">",
        "markerType" => "nowiki"
    );
}

?>
