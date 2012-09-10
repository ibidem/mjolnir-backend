#!/usr/bin/env ruby

require 'rubygems'
require 'fssm'
require 'json'

$basedir = nil;
$config = nil;

def read_configuration()
	json_config = `php -r "chdir('#{$basedir}'); echo json_encode(include '+script.php');"`;
	$config = JSON.parse json_config
	if $config['common'] == nil
		$config['common'] = [];
	end#def

	# include common files
	$config['targets'].each do |key, files|
		$config['targets'][key] = $config['common'] + files;
	end#each

	# convert to paths
	$config['targets'].each do |key, files|
		files.collect! do |file| 'src/'+file+'.js'; end#collect
	end#each
end#def

def regenerate(key, files)
	`java -jar compiler.jar --compilation_level SIMPLE_OPTIMIZATIONS --js #{files.join(' ')} --js_output_file ./closure/#{key}.min.js --create_source_map ./closure/#{key}.min.js.map --source_map_format=V3`;
end#def

def process (r)

	if r.eql? '+script.php'
		puts ' >>> recompiling all...'
		# reload $configuration
		read_configuration();
		# regenerate all
		$config['targets'].each do |key, files|
			regenerate(key, files)
		end#each
	end

	# search configuration for file
	$config['targets'].each do |key, files|
		files.each do |file|
			if file.eql? r
				puts ' >>> recompiling [#{key}]'
				# regenerate the closure
				regenerate(key, files);
			end#if
		end#each
	end#each

end#def

# ---------------------------------------------------------------------------- #

$basedir = File.expand_path(File.dirname(__FILE__));
Dir.chdir $basedir
path = File.expand_path(File.dirname(__FILE__)+'/src');
puts " Monitoring [#{path}] for changes."
puts " ----------------------------------------------------------------------- "
read_configuration();

FSSM.monitor($basedir) do

	update do |b, r|
		puts " >>> changed: #{r}"
		process(r);
	end#do

	create do |b, r|
		puts " >>> created: #{r}"
		process(r);
	end#do

	delete do |b, r|

		# we ignore the remove action

		# puts " >>> removed: #{r}"
		# process(r);
	end#do

end#FSSM
