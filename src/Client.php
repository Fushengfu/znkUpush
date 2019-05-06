<?php
/**
 * 
 */
namespace Amulet;

use Amulet\Umeng\openapi\policy\{
    ClientPolicy,
    RequestPolicy
};
use Amulet\Umeng\openapi\{
    APIId,
    APIRequest,
    SyncAPIClient
};
use Amulet\Umeng\openapi\exception\OceanException;
use Amulet\Umeng\uapp\param\{
    UmengUappGetTodayYesterdayDataParam, UmengUappGetTodayYesterdayDataResult,
    UmengUappGetYesterdayDataParam, UmengUappGetYesterdayDataResult,
    UmengUappGetTodayDataParam, UmengUappGetTodayDataResult, 
    UmengUappGetAllAppDataParam, UmengUappGetAllAppDataResult,
    UmengUappGetAppCountParam, UmengUappGetAppCountResult,
    UmengUappGetChannelDataParam, UmengUappGetChannelDataResult,
    UmengUappGetVersionDataParam, UmengUappGetVersionDataResult,
    UmengUappGetRetentionsParam, UmengUappGetRetentionsResult,
    UmengUappGetDurationsParam, UmengUappGetDurationsResult,
    UmengUappGetLaunchesParam, UmengUappGetLaunchesResult,
    UmengUappGetActiveUsersParam, UmengUappGetActiveUsersResult,
    UmengUappGetNewUsersParam, UmengUappGetNewUsersResult,
    UmengUappGetDailyDataParam, UmengUappGetDailyDataResult,
    UmengUappGetAppListParam, UmengUappGetAppListResult
};

class Client
{
    protected $syncAPIClient = null;

    protected $apiKey = null;

    protected $apiSecurity = null;

    protected $serverHost = null;

    protected $reqPolicy = null;

    protected $result = null;

    protected $request = null;

    public function __construct($apiKey, $apiSecurity, $serverHost = 'gateway.open.umeng.com')
    {
        if (! $apiKey ) {
            throw new Exception("apiKey is required", 1);
        }
        if (! $apiSecurity ) {
            throw new Exception("apiSecurity is required", 1);
        }
        $this->apiKey = $apiKey;
        $this->apiSecurity = $apiSecurity;
        $this->serverHost = $serverHost;
        $this->getApiClientInstance();
        $this->setRequestPolicy();
    }

    public function getApiClientInstance()
    {
        if (null == $this->syncAPIClient) {
            $clientPolicy = new ClientPolicy($this->apiKey, $this->apiSecurity, $this->serverHost);
            $this->syncAPIClient = new SyncAPIClient($clientPolicy);
        }
        return $this;
    }

    /**
     *  设置请求协议
     */
    public function setRequestPolicy()
    {
        $reqPolicy = new RequestPolicy();
        $reqPolicy->httpMethod = "POST";
        $reqPolicy->needAuthorization = false;
        $reqPolicy->requestSendTimestamp = false;
        // 测试环境只支持http
        // $reqPolicy->useHttps = false;
        $reqPolicy->useHttps = true;
        $reqPolicy->useSignture = true;
        $reqPolicy->accessPrivateApi = false;
        $this->reqPolicy = $reqPolicy;
        return $this;
    }

    /**
     *  构造请求
     */
    public function setRequest($param, $name, $namespace = "com.umeng.uapp",  $version = 1)
    {
        $request = new APIRequest();
        $apiId = new APIId($namespace, $name, $version );
        $request->apiId = $apiId;
        $request->requestEntity = $param;
        $this->request = $request;
        return $this;
    }

    /**
     *  构造结果
     */
    public function send()
    {
        try {
            return $this->syncAPIClient->send( $this->request, $this->result, $this->reqPolicy );
        } catch ( OceanException $ex ) {
            echo "Exception occured with code[";
            echo $ex->getErrorCode ();
            echo "] message [";
            echo $ex->getMessage ();
            echo "].";
        }
    }

    /**
     *  获取指定App今天与昨天的统计数据
     *  @param string  $appkey
     */
    public function getTodayYesterdayData($appkey)
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetTodayYesterdayDataParam();
        $param->setAppkey($appkey);
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getTodayYesterdayData");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetTodayYesterdayDataResult();
        return $this->send();
    }

    /**
     *  获取指定App昨日的统计数据
     *  @param string  $appkey
     */
    public function getYesterdayData($appkey)
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetYesterdayDataParam();
        $param->setAppkey($appkey);
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getYesterdayData");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetYesterdayDataResult();
        return $this->send();
    }

    /**
     *  获取指定App今日的统计数据
     *  @param string  $appkey
     */
    public function getTodayData($appkey)
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetTodayDataParam();
        $param->setAppkey($appkey);
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getTodayData");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetTodayDataResult();
        return $this->send();
    }

    /**
     *  获取当前用户所有App昨日和今日的基础统计数据（活跃用户数，新增用户数，启动次数，总用户数）
     *
     */
    public function getAllAppData()
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetAllAppDataParam();
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getAllAppData");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetAllAppDataResult();
        return $this->send();
    }

    /**
     *  获取当前用户所有App的数量
     *
     */
    public function getAppCount()
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetAppCountParam();
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getAppCount");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetAppCountResult();
        return $this->send();
    }

    /**
     *  获取指定App按照分发渠道维度的统计数据
     *  @param string  $appkey
     *  @param string  $date
     */
    public function getChannelData($appkey, $date)
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetChannelDataParam();
        $param->setAppkey($appkey);
        $param->setDate($date);
        $param->setPerPage();
        $param->setPage();
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getChannelData");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetChannelDataResult();
        return $this->send();
    }

    /**
     *  获取指定App按照版本维度的统计数据
     *  @param string  $appkey
     *  @param string  $date
     */
    public function getVersionData($appkey, $date)
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetVersionDataParam();
        $param->setAppkey($appkey);
        $param->setDate($date);
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getVersionData");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetVersionDataResult();
        return $this->send();
    }

    /**
     *  获取指定App某个时间范围内的用户留存率
     *  @param string  $appkey
     *  @param string  $start_at
     *  @param string  $end_at
     */
    public function getRetentions($appkey, $start_at, $end_at)
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetRetentionsParam();
        $param->setAppkey($appkey);
        $param->setStartDate($start_at);
        $param->setEndDate($end_at);
        $param->setPeriodType("daily");
        $param->setChannel("");
        $param->setVersion("");
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getRetentions");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetRetentionsResult();
        return $this->send();
    }

    /**
     *  获取指定App某个时间范围内的使用时长统计数据
     *  @param string  $appkey
     *  @param string  $date
     */
    public function getDurations($appkey, $date)
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetDurationsParam();
        $param->setAppkey($appkey);
        $param->setDate($date);
        $param->setStatType("daily");
        $param->setChannel("App%20Store");
        $param->setVersion("1.0.0");
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getDurations");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetDurationsResult();
        return $this->send();
    }

    /**
     *  获取指定App某个时间范围内的启动次数
     *  @param string  $appkey
     *  @param string  $start_at
     *  @param string  $end_at
     */
    public function getLaunches($appkey, $start_at, $end_at)
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetLaunchesParam();
        $param->setAppkey($appkey);
        $param->setStartDate($start_at);
        $param->setEndDate($end_at);
        $param->setPeriodType("daily");
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getLaunches");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetLaunchesResult();
        return $this->send();
    }

    /**
     *  获取指定App某个时间范围内的活跃用户数
     *  @param string  $appkey
     *  @param string  $start_at
     *  @param string  $end_at
     */
    public function getActiveUsers($appkey, $start_at, $end_at)
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetActiveUsersParam();
        $param->setAppkey($appkey);
        $param->setStartDate($start_at);
        $param->setEndDate($end_at);
        $param->setPeriodType("daily");
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getActiveUsers");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetActiveUsersResult();
        return $this->send();
    }

    /**
     *  获取指定App某个时间范围内的新增用户数
     *  @param string  $appkey
     *  @param string  $start_at
     *  @param string  $end_at
     */
    public function getNewUsers($appkey, $start_at, $end_at)
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetNewUsersParam();
        $param->setAppkey($appkey);
        $param->setStartDate($start_at);
        $param->setEndDate($end_at);
        $param->setPeriodType("daily");
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getNewUsers");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetNewUsersResult();
        return $this->send();
    }

    /**
     *  获取指定App特定日期的统计数据
     *  @param string  $appkey
     *  @param string  $date
     */
    public function getDailyData($appkey, $date)
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetDailyDataParam();
        $param->setAppkey($appkey);
        $param->setDate($date);
        $param->setVersion("");
        $param->setChannel("");
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getDailyData");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetDailyDataResult();
        return $this->send();
    }

    /**
     *  获取当前用户的所有App列表
     *
     */
    public function getAppList()
    {
        // --------------------------构造参数----------------------------------
        $param = new UmengUappGetAppListParam();
        $param->setPage(1);
        $param->setPerPage(10);
        // --------------------------构造请求----------------------------------
        $this->setRequest($param, "umeng.uapp.getAppList");
        // --------------------------构造结果----------------------------------
        $this->result = new UmengUappGetAppListResult();
        return $this->send();
    }
}