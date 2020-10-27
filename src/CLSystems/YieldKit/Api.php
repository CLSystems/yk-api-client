<?php

namespace CLSystems\YieldKit;

use GuzzleHttp\Client;

class Api
{
	const BASE_URI = 'http://api.yieldkit.com';
	const VERSION  = '/v1';

	/**
	 * @var string
	 */
	private $apiKey;

	/**
	 * @var string
	 */
	private $apiSecret;

	/**
	 * @var Client
	 */
	private $client;

	/**
	 * @var string
	 */
	private $siteId;

	/**
	 * Response format
	 * Possible values: json, csv
	 *
	 * @var string
	 */
	private $format = 'json';

	/**
	 * Client constructor.
	 *
	 * @param string $apiKey
	 * @param string $apiSecret
	 */
	public function __construct(string $apiKey, string $apiSecret)
	{
		$this->apiKey = $apiKey;
		$this->apiSecret = $apiSecret;
		$this->client = new Client();
	}

	/**
	 * @param array $params
	 * @return array
	 */
	public function getAdvertiser(array $params): array
	{
		$httpQuery = http_build_query([
			'api_key'    => $this->apiKey,
			'api_secret' => $this->apiSecret,
			'site_id'    => $this->getSiteId(),
			'format'     => $this->getFormat(),
		] + $params);
		$options = [
			'headers' => ['Accept' => 'application/json'],
		];
		$response = $this->client->get(self::BASE_URI . self::VERSION . '/advertiser?' . $httpQuery, $options)->getBody();
		$result = json_decode($response, true);

		if (false === $result)
		{
			echo 'Error in response: ' . var_export($response, true);
			return [];
		}
		return $result;
	}

	/**
	 * @return string
	 */
	public function getFormat() : string
	{
		return $this->format;
	}

	/**
	 * @param string $format
	 */
	public function setFormat(string $format) : void
	{
		$this->format = $format;
	}

	/**
	 * @return string
	 */
	public function getSiteId() : string
	{
		return $this->siteId;
	}

	/**
	 * @param string $siteId
	 */
	public function setSiteId(string $siteId) : void
	{
		$this->siteId = $siteId;
	}

}
