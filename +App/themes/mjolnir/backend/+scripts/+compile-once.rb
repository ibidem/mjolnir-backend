#!/usr/bin/env ruby

require 'rubygems'
require 'json'

$basedir = nil;
$config = nil;

# $compiler_options = ' --process_jquery_primitives --warning_level QUIET --third_party --compilation_level WHITESPACE_ONLY'
$compiler_options = ' --process_jquery_primitives --warning_level QUIET --third_party --compilation_level WHITESPACE_ONLY --formatting PRETTY_PRINT'

def read_configuration()
	json_config = `php -r "chdir('#{$basedir}'); echo json_encode(include '+script.php');"`;
	$config = JSON.parse json_config
	if $config['common'] == nil
		$config['common'] = [];
	else # not nil
		$config['common'] = $config['common'].find_all do |item| item !~ /(^[a-z]+:\/\/|^\/\/).*$/ end
	end#def

	# include common files
	$config['targets'].each do |key, files|
		files = files.find_all do |item| item !~ /(^[a-z]+:\/\/|^\/\/).*$/ end
		$config['targets'][key] = $config['common'] + files;
	end#each

	# convert to paths
	$config['targets'].each do |key, files|
		files = files.find_all do |item| item !~ /(^[a-z]+:\/\/|^\/\/).*$/ end
		files.collect! do |file| 'src/'+file+'.js'; end#collect
		$config['targets'][key] = files
	end#each

	# convert to paths
	files = $config['complete-script']
	files = files.find_all do |item| item !~ /(^[a-z]+:\/\/|^\/\/).*$/ end
	files.collect! do |file| 'src/'+file+'.js'; end#collect
	$config['complete-script'] = files
	
end#def

def recompile()
	if ($config['complete-mode'])
		regenerate('complete-script', $config['complete-script'])
	else # standard mode
		$config['targets'].each do |key, files|
			regenerate(key, files)
		end#each
	end#if
end#def

def regenerate(key, files)
	puts " compiling #{key}"
	`java -jar compiler.jar #{$compiler_options} --js #{files.join(' ')} --js_output_file ./closure/#{key}.min.js --create_source_map ./closure/#{key}.min.js.map --source_map_format=V3`;
end#def

def process (r)

	if r.eql? '+script.php'
		puts ' >>> recompiling all...'
		# reload $configuration
		read_configuration();
		if $config['complete-mode']
			regenerate('complete-script', $config['complete-script'])
		else # non-complete mode
			# regenerate all
			$config['targets'].each do |key, files|
				regenerate(key, files)
			end#each
		end#if
	end

	if $config['complete-mode']
	
		$config['complete-script'].each do |file|
			if file.eql? r
				puts " >>> recompiling [complete-script]"
				# regenerate the closure
				recompile()
				break;
			end#if
		end#each

	else # non-complete mode

		# search configuration for file
		$config['targets'].each do |key, files|
			files.each do |file|
				if file.eql? r
					puts " >>> recompiling [#{key}]"
					# regenerate the closure
					regenerate(key, files);
				end#if
			end#each
		end#each
		
	end#if

end#def

# ---------------------------------------------------------------------------- #

$basedir = File.expand_path(File.dirname(__FILE__));
Dir.chdir $basedir
path = File.expand_path(File.dirname(__FILE__)+'/src');

puts 
puts " Recompiling..."
puts " ----------------------------------------------------------------------- "
read_configuration();
recompile();
puts " >>> all files regenarated "
