<?php

$phawk    = __DIR__  . '/../phawk';
$testFilePath = __DIR__ . '/test_files/';
$simpleTestFile = $testFilePath . 'simple_test.txt';
$passed = 0;

foreach(get_defined_functions()['user'] as $func){    
    if(strpos($func, 'test_') === 0){        
        $func();
    }
}

function test_pipe_simple_file(){        
    global $phawk;
    global $simpleTestFile;            
    $result = shell_exec("cat $simpleTestFile | php $phawk '" . 'echo $v1, $v2;' . "'");
    simple_assert($result === '1256ABEFIJMN');            
}

function test_print_line_numbers(){
    global $phawk;
    global $simpleTestFile;        
    $result = shell_exec("cat $simpleTestFile | php $phawk '" . 'echo $ln;' . "'");    
    simple_assert($result === '123456');            
}

function test_bool_functionality(){
    global $phawk;
    global $simpleTestFile;        
    $result = shell_exec("cat $simpleTestFile | php $phawk '" . '$display = $ln %2 ===0;' . "'");    
    simple_assert(substr_count($result, "\n") === 3);            
}

function test_begin_end_functionality() {
    global $phawk;
    global $simpleTestFile;        
    $result = shell_exec("cat $simpleTestFile | php $phawk " . '\'$myVar = 0;\' \'$myVar++;$display = false;\' \'echo $myVar;\'' );        
    simple_assert($result == 6);            
}

function test_wrong_number_arguments() {
    global $phawk;
    global $simpleTestFile;        
    $result = shell_exec("cat $simpleTestFile | php $phawk " . '\'$myVar = 0;\' \'$myVar++;$display = true;\'' );                
    simple_assert(!$result);            
}

function test_field_seperators() {
    global $phawk;
    $pattern = "'test,test,test,test'";
    $result = shell_exec("echo $pattern | php $phawk " . '\'echo $v1;\' \',\'' );            
    simple_assert($result === 'test');                
    $result = shell_exec("echo $pattern | php $phawk " . '\'$myvar=1;\' \'echo $v1;\' \'$myvar=2;\' \',\'' );                    
    simple_assert($result === 'test');            
}

function simple_assert($bool){
    global $passed;
    $trace  = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
    $line   = $trace[0]['line'];                 
    $method = $trace[1]['function'];
    if(!$bool){        
        $passed = 1;
        echo "Test [$method] failed assertion at line $line" , "\n";
    } else {
        echo "Passed assertion from [$method] line $line" , "\n";
    }
}

exit($passed);