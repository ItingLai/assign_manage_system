# personal_manage_system 人事管理系統

使用 [Vue](https://cn.vuejs.org/) +[ElementUI](https://element-plus.org/en-US/)結合完成的人事管理系統.

## 客製化

- 可透過更改 Logo 或者名稱進行客製化
- 自行下載並修改[FrontEnd](https://github.com/ItingLai/personal_manage_system_Frontend)
- 修改資料庫設定檔，請視當前主機帳號密碼修改
  ![image](https://github.com/ItingLai/personal_manage_system/blob/main/docs/img/config_setting.png)

## 功能介紹

![image](https://github.com/ItingLai/personal_manage_system/blob/main/docs/img/menu.png)

### 通用功能

#### 登入

- 輸入人事已分配的帳號及密碼進行登入(密碼預設手機號碼)
  ![image](https://github.com/ItingLai/personal_manage_system/blob/main/docs/img/login_page.png)

#### 請假

- 透過點擊日曆上的日期即可選擇假別完成請假
  ![image](https://github.com/ItingLai/personal_manage_system/blob/main/docs/img/apply_leave.png)
- 假別:事假、病假、公假
  ![image](https://github.com/ItingLai/personal_manage_system/blob/main/docs/img/leave_form.png)
- 請假紀錄可在紀錄裡查詢，也可以得知該假別是否已審核
  ![image](https://github.com/ItingLai/personal_manage_system/blob/main/docs/img/leave_history.png)
- 審核通過將會自動更新在排班表內容

#### 薪資條

- 當人事及會計確認薪水，薪資資訊將會同步顯示在薪資條功能
- 薪資條功能會顯示出席天數、請假天數、曠班天數、底薪、健保費、勞保費及其他獎金，並計算出結果
  ![image](https://github.com/ItingLai/personal_manage_system/blob/main/docs/img/salary_info.png)

#### 排班表

- 可透過排班表確認哪位員工應該出席，更好了解當天的應該出席狀況
- 當請假審核通過，將會同步更新排班表資訊
  ![image](https://github.com/ItingLai/personal_manage_system/blob/main/docs/img/attend_sheet.png)

### 各角色功能(可設定 4 種角色,Accounting、Personal、Manager、Staff)

#### Boss

- 需先透過老闆帳號新增人事帳號，人事方可進行人事管理
- 老闆擁有所有功能權限

#### Personal

- 人事擁有管理職務功能,可透過新增人事管理功能管理公司人員,新增人員須輸入底薪、姓名、帳號名稱、住址、職位、手機電話(預設密碼)
  ![image](https://github.com/ItingLai/personal_manage_system/blob/main/docs/img/personal_manage.png)
  ![image](https://github.com/ItingLai/personal_manage_system/blob/main/docs/img/personal_manage_form.png)
- 手動調整員工出席狀況，可透過該功能手動修該出缺席或者假別
  ![image](https://github.com/ItingLai/personal_manage_system/blob/main/docs/img/manage_attend.png)
- 審核請假申請，可准許或者拒絕請假申請，結果將會同步顯示在該名員工的請假紀錄上
- 人事可使用計算薪水計算全公司員工薪水，如出缺席結果有誤可透過手動調整功能進行調整，計算完成還需會計進行最後確認，當會計審核通過將會顯示在每個員工的薪資條功能上。
- 重置員工密碼功能，當員工忘記密碼時可透過人事管理系統點擊該名員工資訊，方可進行密碼重置(預設密碼為手機號碼)。

#### Accounting

- 會計需在薪水確認功能上確認最後薪資結果，如果有誤需通知人事重新調整出席並重新計算
- 當會記確認最後薪水，薪資資訊將會同步顯示在每位員工的薪資條功能

#### Manager

- 主管可負責其下屬的請假審核
- 主管也可以審核其下屬出差申請，准許的話將會同步顯示在排班表功能

#### Staff

- 員工可進行請假及其他基本操作
