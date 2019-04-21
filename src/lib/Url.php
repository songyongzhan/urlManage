<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2019/4/21
 * Time: 20:16
 * Auth songyongzhan
 * Email 574482856@qq.com
 */

namespace songyongzhan\url;
class Url {
  /**
   *
   * @var 原始url
   */
  public $url;
  /**
   * @var url协议
   */
  public $scheme;
  /**
   * @var 主机域名
   */
  public $host;
  /**
   * @var 路径
   */
  public $path;
  /**
   * @var 参数
   */
  public $querys;
  /**
   * @var 锚点
   */
  public $fragment;

  /**
   * @var 端口号
   */
  public $port;

  public function __construct($url) {
    if (!$url)
      throw new InvalidArgumentException('url参数错误');

    $this->url = $url;
    $this->parseUrl($this->url);
  }

  /**
   * 解析url
   * @param $url
   */
  private function parseUrl($url) {

    $urlParams = parse_url($url);

    $this->scheme = isset($urlParams['scheme']) ? $urlParams['scheme'] : 'http';
    $this->host = isset($urlParams['host']) ? $urlParams['host'] : '';
    $this->port = isset($urlParams['port']) ? $urlParams['port'] : 80;
    $this->path = isset($urlParams['path']) ? $urlParams['path'] : '';

    $this->querys = [];
    if (isset($urlParams['query'])) {
      parse_str($urlParams['query'], $httpQuerys);
      $this->querys = $httpQuerys;
    }
    $this->fragment = isset($urlParams['fragment']) ? $urlParams['fragment'] : '';
  }

  /**
   * 设置url协议头
   * @param string $scheme
   * @return $this
   */
  public function setScheme($scheme) {
    if (!$scheme)
      throw new InvalidArgumentException('scheme设置协议头不能为空');

    if (in_array($scheme, ['https', 'http']))
      $this->scheme = $scheme;

    return $this;
  }

  /**
   * 设置端口号
   * @param int $port
   * @return $this
   */
  public function setPort($port) {
    if (is_int($port))
      $this->port = $port;
    return $this;
  }


  /**
   * 设置host
   * @param string $host
   * @return $this
   */
  public function setHost($host) {
    if (!$host)
      throw new InvalidArgumentException('host设置不能为空');

    $this->host = $host;
    return $this;
  }

  /**
   * 设置path
   * @param string $path
   * @return $this
   */
  public function setPath($path) {
    if (!$path)
      throw new InvalidArgumentException('path设置不能为空');

    if (mb_substr($path, 0, 1) !== '/')
      $path = '/' . $path;

    $this->path = $path;
    return $this;
  }

  /**
   * 设置锚点
   * @param $fragment
   * @return $this
   */
  public function setFragment($fragment) {
    $this->fragment = $fragment;
    return $this;

  }

  /**
   * 删除query中的某个参数
   * @param string $name
   * @return $this
   */
  public function delQuerys($name) {
    if (isset($this->querys[$name]))
      unset($this->querys[$name]);
    return $this;
  }

  /**
   * 在query中增加参数
   * @param sring|array $name
   * @param string $val
   * @return $this
   */
  public function addQuerys($name, $val = '') {
    if (is_array($name))
      $this->querys = array_merge($this->querys, $name);
    else
      $this->querys[$name] = $val;
    return $this;
  }

  /**
   * 获取新的url
   * @return string
   */
  public function getUrl() {

    $fragment = $this->fragment ? '#' . $this->fragment : '';
    $querys = $this->querys ? '?' . http_build_query($this->querys) : '';
    $port = $this->port == 80 ? '' : ':' . $this->port;

    $url = sprintf("%s://%s%s%s%s%s",
      $this->scheme,
      $this->host,
      $port,
      $this->path,
      $querys,
      $fragment
    );
    return $url;
  }
}