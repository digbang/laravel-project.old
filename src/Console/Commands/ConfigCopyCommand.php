<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

class ConfigCopyCommand extends Command
{
	protected $name = 'config:copy';

	protected $description = 'Copy the example config and interactively change it.';

	/**
	 * @type Filesystem
	 */
	private $file;

	/**
	 * @type string
	 */
	private $target;

	private $forcedValues = [];

	function __construct(Filesystem $file)
	{
		$this->file = $file;

		parent::__construct();
	}

	public function fire()
	{
		$path = $this->option('from');
		$env = $this->laravel->environment();

		if (! $this->file->exists($path))
		{
			$this->error("File $path does not exist.");

			return 1;
		}

		$vars = include $path;

		$this->parseSetOption();

		$output = [];
		$this->recursiveAsk($vars, $output);

		$longestKey = $this->getLongestKey($output);

		$this->target = '.env' . ($env != 'production' ? ".$env" : '') . '.php';

		$this->file->put($this->target, '<?php' . PHP_EOL);
		$this->append('return [', 0);

		foreach ($output as $key => $value)
		{
			if (is_array($value))
			{
				$this->append($this->quoteByType($key) . " => serialize([");

				$this->recursiveAppend($value);

				$this->append("]),");
			}
			else
			{
				$this->append($this->keyval($key, $value, $longestKey));
			}
		}

		$this->append('];', 0);
	}

	private function append($string, $level = 1)
	{
		$this->file->append(
			$this->target,
			str_repeat('    ', $level) . $string . PHP_EOL
		);
	}

	private function keyval($key, $val, $longestKey)
	{
		$key = $this->quoteByType($key);
		$val = $this->quoteByType($val);

		$key = str_pad($key, $longestKey, ' ', STR_PAD_RIGHT);
		return "$key => $val,";
	}

	private function quoteByType($val)
	{
		switch (true)
		{
			case is_null($val):
				return 'null';
			case is_bool($val):
				return $val ? 'true' : 'false';
			case is_numeric($val):
				return $val;
			case is_string($val):
				if (in_array(strtolower($val), ['true', 'false']))
				{
					return $val;
				}
				// no break
			default:
				return "'$val'";
		}
	}

	private function recursiveAppend($data, $level = 2)
	{
		$longestKey = $this->getLongestKey($data);
		foreach ($data as $key => $value)
		{
			if (is_array($value))
			{
				$this->append($this->quoteByType($key) . " => [", $level);
				$this->recursiveAppend($value, $level + 1);
				$this->append("],", $level);
			}
			else
			{
				$this->append($this->keyval($key, $value, $longestKey), $level);
			}
		}
	}

	private function recursiveAsk(array $vars, &$output, $prevKeys = [])
	{
		$prev = implode(':', $prevKeys);
		foreach ($vars as $key => $value)
		{
			$data = $value;
			if (is_string($value))
			{
				$data = @unserialize($value);
			}

			if (is_array($data))
			{
				$output[$key] = [];

				$prevKeys[] = $key;
				$this->recursiveAsk($data, $output[$key], $prevKeys);
			}
			else
			{
				$keyMsg = ($prev ? "$prev:" : '') . $key;
				$output[$key] = $this->getValue($key, $value, $keyMsg);
			}
		}
	}

	protected function getOptions()
	{
		return [
			['from', null, InputOption::VALUE_OPTIONAL, 'The example config file path.', 'example.env.php'],
			['set', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Force certain key to take the given value', []],
			['silent', null, InputOption::VALUE_NONE, 'Make no interactions. Useful for automated processes'],
		];
	}

	/**
	 * @param $array
	 *
	 * @return int
	 */
	private function getLongestKey($array)
	{
		return 2 + array_reduce(
			array_keys($array),
			function ($carry, $item) {
				if (strlen($item) > $carry){
					return strlen($item);
				}

				return $carry;
			},
			0
		);
	}

	/**
	 * @param $key
	 * @param $default
	 * @param $msg
	 *
	 * @return string
	 */
	private function getValue($key, $default, $msg)
	{
		if (array_key_exists($key, $this->forcedValues))
		{
			return $this->forcedValues[$key];
		}

		if ($this->option('silent'))
		{
			return $default;
		}

		$quoted = $this->quoteByType($default);
		return $this->ask("$msg: [$quoted]</question> <question>", $default);
	}

	private function parseSetOption()
	{
		$sets = $this->option('set');

		if (! $sets)
		{
			$this->forcedValues = [];
			return;
		}

		foreach ($sets as $set)
		{
			list($key, $value) = array_map('trim', explode('=', $set));

			$this->forcedValues[$key] = $value;
		}
	}
}
