<?php


namespace Hogus\Tencent\Tim\Supports;


class Filter
{
    public $GroupBaseInfoFilter = [
        "Type",               //群类型(包括Public(公开群), Private(私密群), ChatRoom(聊天室))
        "Name",               //群名称
        "Introduction",       //群简介
        "Notification",       //群公告
        "FaceUrl",            //群头像url地址
        "CreateTime",         //群组创建时间
        "Owner_Account",      //群主id
        "LastInfoTime",       //最后一次系统通知时间
        "LastMsgTime",        //最后一次消息发送时间
        "MemberNum",          //群组当前成员数目
        "MaxMemberNum",       //群组内最大成员数目
        "ApplyJoinOption"
    ];

    public $MemberInfoFilter = [
        "Account",         // 成员ID
        "Role",            // 成员身份
        "JoinTime",        // 成员加入时间
        "LastSendMsgTime", // 该成员最后一次发送消息时间
        "ShutUpUntil"      // 该成员被禁言直到某时间
    ];

    public $AppDefinedDataFilter_Group = [
        "GroupTestData1",  //自定义数据
    ];
}
