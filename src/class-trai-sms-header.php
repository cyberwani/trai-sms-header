<?php
namespace Cyberwani\TRAI_SMS_Header;

class TRAI_SMS_Header
{
	protected array $operatorMap;
	protected array $circleMap;
	protected array $suffixMap = [
		'P' => 'Promotional',
		'S' => 'Service',
		'T' => 'Transactional',
		'G' => 'Government (TRAI-exempted headers only)',
	];

	protected ?array $senderList = null;

	/**
	 * Constructor.
	 * @param string|null $senderJsonPath Optional custom sender JSON file path.
	 *                                    If not provided, defaults to /Data/sender-list.json
	 */
	public function __construct(?string $senderJsonPath = null)
	{
		$this->operatorMap = require __DIR__ . '/data/operator-map.php';
		$this->circleMap   = require __DIR__ . '/data/circle-map.php';

		// Default JSON path if not provided
		if (!$senderJsonPath) {
			$senderJsonPath = __DIR__ . '/data/sender-list.json';
		}

		if (file_exists($senderJsonPath)) {
			$this->senderList = json_decode(file_get_contents($senderJsonPath), true);
		} else {
			$this->senderList = [];
		}
	}

	/**
	 * Inspect a TRAI-compliant SMS header (e.g. VM-ABCDEF-S)
	 */
	public function inspect(string $header): array
	{
		$header = strtoupper(trim($header));
		$result = ['input' => $header, 'valid' => false];

		// Extract suffix (-P, -S, -T, -G)
		$suffix = null;
		if (preg_match('/[-]?([PSTG])$/', $header, $m)) {
			$suffix = $m[1];
			$header = preg_replace('/[-]?([PSTG])$/', '', $header);
		}

		// Match prefix (XY) and sender
		if (!preg_match('/^([A-Z]{2})[-]?([A-Z0-9]{1,11})$/', $header, $m)) {
			$result['error'] = 'Invalid header format. Expected VM-ABCDEF-S';
			return $result;
		}

		$xy = $m[1];
		$senderId = $m[2];
		$opCode = $xy[0];
		$circleCode = $xy[1];

		$operator = $this->operatorMap[$opCode] ?? null;
		$circle   = $this->circleMap[$circleCode] ?? null;
		$senderName = $this->senderList[$senderId] ?? 'Unknown';

		return [
			'input'         => $header,
			'prefix'        => $xy,
			'operator_code' => $opCode,
			'operator'      => $operator ?? 'Unknown',
			'circle_code'   => $circleCode,
			'circle'        => $circle ?? 'Unknown',
			'sender_id'     => $senderId,
			'sender_name'   => $senderName ?? 'Unknown',
			'suffix'        => $suffix ? "-{$suffix}" : null,
			'message_type'  => $suffix ? ($this->suffixMap[$suffix] ?? 'Unknown') : 'Not specified',
			'valid'         => (bool) ($operator && $circle),
		];
	}
}
