-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 05:19 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ctustucom`
--

-- --------------------------------------------------------

--
-- Table structure for table `baiviet_baocao`
--

CREATE TABLE `baiviet_baocao` (
  `ND_MA` int(11) NOT NULL,
  `BV_MA` int(11) NOT NULL,
  `BVBC_THOIDIEM` datetime NOT NULL,
  `BVBC_NOIDUNG` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `baiviet_baocao`
--

INSERT INTO `baiviet_baocao` (`ND_MA`, `BV_MA`, `BVBC_THOIDIEM`, `BVBC_NOIDUNG`) VALUES
(1, 15, '2024-05-14 12:26:03', 'Spam/Quảng cáo'),
(1, 27, '2024-05-15 10:10:42', 'Ngôn từ không phù hợp'),
(7, 15, '2024-05-14 12:27:59', 'Spam/Quảng cáo');

-- --------------------------------------------------------

--
-- Table structure for table `baiviet_thich`
--

CREATE TABLE `baiviet_thich` (
  `ND_MA` int(11) NOT NULL,
  `BV_MA` int(11) NOT NULL,
  `BVT_THOIDIEM` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `baiviet_thich`
--

INSERT INTO `baiviet_thich` (`ND_MA`, `BV_MA`, `BVT_THOIDIEM`) VALUES
(1, 20, '2024-05-14 12:22:25'),
(2, 1, '2024-05-14 01:34:13'),
(2, 8, '2024-05-14 03:16:40'),
(4, 1, '2024-05-14 01:32:15'),
(4, 2, '2024-05-14 01:32:16'),
(4, 3, '2024-05-14 01:59:07'),
(5, 3, '2024-05-14 01:42:08'),
(5, 6, '2024-05-14 04:09:24'),
(5, 7, '2024-05-14 04:09:22'),
(5, 8, '2024-05-14 04:09:21'),
(5, 9, '2024-05-14 04:09:20'),
(5, 10, '2024-05-14 04:09:18'),
(5, 11, '2024-05-14 04:09:17'),
(5, 12, '2024-05-14 04:09:14'),
(7, 1, '2024-05-14 04:35:13'),
(7, 2, '2024-05-14 02:20:28'),
(7, 4, '2024-05-14 04:35:07'),
(7, 5, '2024-05-14 04:35:08'),
(7, 6, '2024-05-14 04:35:10'),
(7, 7, '2024-05-14 04:35:10'),
(7, 8, '2024-05-14 04:34:40'),
(7, 9, '2024-05-14 04:34:39'),
(7, 10, '2024-05-14 04:34:35'),
(7, 12, '2024-05-14 04:34:30'),
(7, 16, '2024-05-14 12:25:33'),
(7, 20, '2024-05-14 12:25:22'),
(7, 23, '2024-05-15 10:04:36'),
(15, 23, '2024-05-15 08:55:11'),
(16, 9, '2024-05-14 11:45:20'),
(16, 13, '2024-05-14 11:45:21'),
(16, 16, '2024-05-14 11:45:44'),
(16, 18, '2024-05-14 11:45:43'),
(16, 19, '2024-05-14 11:45:18'),
(16, 20, '2024-05-14 12:20:17'),
(17, 3, '2024-05-14 11:43:53'),
(17, 5, '2024-05-14 11:41:55'),
(17, 8, '2024-05-14 11:42:44'),
(17, 10, '2024-05-14 11:42:43'),
(17, 11, '2024-05-14 11:41:54'),
(17, 14, '2024-05-14 11:41:51'),
(17, 16, '2024-05-14 11:42:54'),
(17, 18, '2024-05-14 11:41:53'),
(18, 9, '2024-05-14 11:49:26'),
(18, 13, '2024-05-14 11:49:25'),
(18, 19, '2024-05-14 11:49:23'),
(20, 6, '2024-05-14 12:05:01'),
(20, 7, '2024-05-14 12:04:23'),
(20, 13, '2024-05-14 12:04:24'),
(20, 20, '2024-05-14 12:27:59');

-- --------------------------------------------------------

--
-- Table structure for table `bai_viet`
--

CREATE TABLE `bai_viet` (
  `BV_MA` int(11) NOT NULL,
  `ND_MA` int(11) NOT NULL,
  `HP_MA` char(5) DEFAULT NULL,
  `BV_TIEUDE` varchar(150) NOT NULL,
  `BV_NOIDUNG` text NOT NULL,
  `BV_TRANGTHAI` varchar(255) NOT NULL,
  `BV_THOIGIANTAO` datetime NOT NULL,
  `BV_THOIGIANDANG` datetime DEFAULT NULL,
  `BV_LUOTXEM` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `bai_viet`
--

INSERT INTO `bai_viet` (`BV_MA`, `ND_MA`, `HP_MA`, `BV_TIEUDE`, `BV_NOIDUNG`, `BV_TRANGTHAI`, `BV_THOIGIANTAO`, `BV_THOIGIANDANG`, `BV_LUOTXEM`) VALUES
(1, 4, NULL, 'CẢNH BÁO MÓC TÚI Ở B1', 'MNG ƠI, HÔM NAY EM CÓ HỌC Ở NHÀ HỌC B1 VÀ BỊ 1 BẠN NỮ MÓC BÓP Ạ (bạn này cao, trắng, ốm) MNG HỌC Ở B1 CẨN THẬN TIỀN BẠC NHA', 'Đã duyệt', '2024-04-01 03:29:25', '2024-04-01 03:32:57', 42),
(2, 4, NULL, '\"Ăn chay vì sức khoẻ và môi trường\" căn tin B1 lại tiếp tục chuỗi TẶNG đồ ăn chay mỗi tháng', 'Vào sáng thứ 5, ngày 11/1/2024 (nhằm ngày 1 tháng 12 lâm lịch) từ  #6h đến 7h.\nĐịa chỉ: Căn tin B1 đối diện nhà học B1 kế bên nhà xe B1 nha mọi người\nVới những món ăn chay phong phú, nên các bạn tranh thủ đến sớm nhé.\nP/s: Mọi người có đóng góp ý kiến hay muốn tham gia vào đội thiện nguyện của Căn tin B1 cứ ib thẳng vào mess mình nhé!!!\nNgoài ra, Căn tin B1 còn phục vụ đồ ăn và thức uống mọi người ủng hộ nhé.\n#xin lỗi mọi người mìk đăng trễ ạ!!!', 'Đã duyệt', '2024-04-01 03:32:39', '2024-04-01 03:41:55', 12),
(3, 5, NULL, 'Cảnh giác móc túi sau Tết', 'Ban đầu em bị móc bóp, mất số tiền khá lớn thì em nghĩ em quá bất cẩn, không cẩn thận, nhưng sau khi em thấy nhiều người mất, thì em cảm thấy bạn nữ đó không ra gì, cũng cao cũng đẹp mà làm ra loại chuyện này. Mà không phải 1 lần mà nhiều lần và quá chuyên nghiệp, cặp để kế bên mà còn không hay, em ngồi ngay cửa sau nhiều người ra vào nó mạnh dạn ra đống cửa để hành sự luôn. Em còn tưởng nó bị chói nắng:))) \nCHỈ MONG MỌI NGƯỜI CẢNH GIÁC, đi học thì để bóp bên mình đừng rời nó luôn, ăn cắp quen tay ngủ ngày quen mắt, xinh thì xinh chứ ăn cắp thấy ớn. \nThật ra em có đăng cfs mấy ngày trước mà ad toàn duyệt mấy chuyện thả thính, mấy cái cảnh báo không thấy đâu, mà lại có thêm người bị móc bóp nên em lên đăng luôn để mọi người tránh.', 'Đã duyệt', '2024-04-01 03:51:55', '2024-04-01 03:52:07', 14),
(4, 3, NULL, 'Thắc mắc thi lái xe', 'Mn ơi mình tính đk thi lái xe A1 ở gần trường cnnt, kế vp đoàn thanh niên giờ còn kịp thi trong tháng 2 kh, và khi thi thì mình thi tại trường hay chỗ khác ạ.', 'Vi phạm tiêu chuẩn: Thông tin sai sự thật', '2024-04-02 04:18:13', '2024-04-02 04:18:43', 15),
(5, 7, NULL, 'Mình cần tư vấn về chứng chỉ ngoại ngữ', 'anh chị cho em hỏi\n1 nên học B1 hay toeic \n2 nếu bằng toeic hết hạn trước lúc mình tốt nghiệp thì có cần thi lại không, hay mình chỉ cần nộp cho trường lúc bằng còn hạn là được ạ?\nem cảm ơn ạ', 'Đã duyệt', '2024-04-03 04:26:14', '2024-04-03 04:26:25', 15),
(6, 2, 'KL369', 'Chia sẻ tài liệu ôn Luật Kinh tế', 'Link danh mục tài liệu tham khảo Luật học và kinh tế.\n1. Tài liệu luật học:\nhttps://docs.google.com/document/d/10rVL6YifQt87vMvydgyXOBfnETwHEM66/edit?rtpof=true&sd=true&fbclid=IwAR0eUKPO0LaTVfU6YkBd4maC3t7q71TTqsj06NvjvCzI3hIsTkLzIjUvCSM#heading=h.gjdgxs\n\n2. Tài liệu kinh tế:\nhttps://docs.google.com/document/d/10rVL6YifQt87vMvydgyXOBfnETwHEM66/edit?rtpof=true&sd=true&fbclid=IwAR11AEH7Ipsds6jg4_3_n-dbXeCYPbGO1sEM3lg_P9kn3grFWR1IUnKR4Sw\n\n3. Website tài liệu trực tuyến:\nhttps://tailieuluatkinhte.com/\nChúc các bạn học tốt <3', 'Đã duyệt', '2024-04-03 04:58:23', '2024-04-03 05:02:56', 8),
(7, 9, NULL, 'Tìm đồ đánh rơi ở nhà thi đấu', 'Góc tìm đồ\nVào lúc gần 9g tối tại nhà thi đấu cũ trường Đại học Cần Thơ, em mình có làm rơi cái ví màu đen, bên trong có:\nCăn cước công dân mang tên: Lê Huỳnh Tuyết Như, mã số:083303002xxx\n1 thẻ Vietcombank cùng tên\n1tr tiền mặt\nMọi người ai có nhặt được thì vui lòng liên hệ qua nhắn tin hoặc gọi đến sdt: 0111590011\nMình xin cảm ơn và hậu tạ', 'Đã duyệt', '2024-04-05 05:13:59', '2024-04-05 05:14:10', 5),
(8, 8, 'ML016', 'Xin tài liệu Kinh tế chính trị', 'Mọi người có tài liệu ôn tập hay tài liệu tự soạn môn KTCT cho em xin với ạ. Em cảm ơn nhìu ạ', 'Đã duyệt', '2024-04-07 05:26:01', '2024-04-07 05:26:19', 23),
(9, 3, NULL, 'Pass tài liệu CNSH và môn đại cương', 'Mình có vài tài liệu cần pass ạ. Cho ngành Công nghệ sinh học và 1 số môn đại cương\n( Mình k có ship các bạn đến Viện CNSH & TP lấy giúp mình nha).\n#Hết --> luật, kinh tế chính trị, sinh học miễn dịch, lên men, tư tưởng HCM.', 'Đã duyệt', '2024-04-08 05:30:43', '2024-05-14 11:55:09', 13),
(10, 8, 'QP010', 'Kinh nghiệm đi học ở Hoà An', 'Anh chị di Hoa An rồi cho em xin ít kinh nghiệm vs ạ, đầu tháng 1 em đi ơì', 'Đã duyệt', '2024-04-13 05:45:56', '2024-04-13 05:46:12', 13),
(11, 1, NULL, 'Ký hiệu phòng học Khu 2', 'Gửi các bạn k49', 'Đã duyệt', '2024-04-18 05:52:47', '2024-04-18 05:52:56', 47),
(12, 11, NULL, 'Học bổng đi Nhật 1 năm cho bạn nào quan tâm', 'Đối tượng hỗ trợ: các bạn SV sắp hoặc đã tốt nghiệp các chuyên ngành, các bạn có hoàn cảnh khó khăn.', 'Đã duyệt', '2024-04-18 06:14:58', '2024-04-18 06:15:44', 13),
(13, 9, NULL, 'Góc tâm sự', 'Hi mọi người, mình hiện là sinh viên sư phạm năm 3 ở ctu. Thiệt ra mình muốn tâm sự một vấn đề mà nghĩ nhiều bạn sinh viên sư phạm cũng muốn nói là về trợ cấp của sinh viên sư phạm từ k47. Tụi mình được nhận trợ cấp năm nhất đầy đủ nhưng mà qua năm ba rồi vẫn chưa nhận được tháng nào từ năm hai do lí do chưa có tiền từ phía trên gửi về trường. Mình không có ý nói sẽ không được nhận nữa đâu mà chỉ muốn bày tỏ hoàn cảnh mình cũng khó khăn, lựa chọn ngành sư phạm cũng là vì trợ cấp và mình nghĩ cũng có nhiều bạn giống mình. Mình thấy có nhiều bạn và cả mình vì chưa nhận được trợ cấp nên phải đi làm thêm để bớt gánh nặng gia đình, điều này cũng ảnh hưởng đến kết quả học tập không ít. Nhiều bạn đã đặt cược tương lai để lựa chọn ngành sư phạm chỉ vì trợ cấp để bớt gánh nặng học đại học như thế thì mình nghĩ sẽ thật tốt nếu có trợ cấp đúng hẹn, phải không mọi người? Tụi mình cũng chỉ là sinh viên nên chỉ có thể lên đây để chia sẻ tâm sự một chút thôi không biết mọi người cảm thấy thế nào.', 'Đã duyệt', '2024-04-19 06:33:54', '2024-05-14 11:55:01', 1),
(14, 7, NULL, 'ĐẠI HỌC CẦN THƠ VÀ NHỮNG ĐIỀU THÚ VỊ', '1. Không phải khoe nhưng Trường là một trong ba trường đại học tại Việt Nam đạt chuẩn đào tạo quốc tế của Hệ thống đại học ASEAN, bằng cấp có giá trị sử dụng toàn Đông Nam Á, đỉnk chưa?!?\n2. Nói đi học ĐH ở Cần Thơ là ai cũng nghĩ mình học ĐH Cần Thơ, khỏi phải giải thích nhiều. \n3. Khu II của ĐH Cần Thơ nằm ở đường 3/2 có kem xôi ngon mlem mlem mà còn rẻ nữa.\n4. Ở Sài Gòn có Hồ Con Rùa còn ở ĐH Cần Thơ có Hội trường Rùa, vòng xoay Rùa, còn bonus thêm vườn bàng mát mẻ, gảnk thì dzô chơi. \n5. Nói với bạn học ở ĐH Cần Thơ cái nó hỏi có gần bến Ninh Kiều hông. \n6. Có Hội những người anti những con ve CTU thành lập kịp thời vào mùa ve kêu rộn ràng nghe mệt muốn xỉu, mà hết mùa ve kêu thì chắc phải ngưng hoạt động đợi mùa ve năm sau. \n7. Sinh viên CTU không phải ai cũng ế nhưng đa phần là hổng có bồ. \n8. Trường có nhiều khu, trụ sở chính là khu II, còn có khu Hoà An nằm ở Hậu Giang nữa.\n9. Cũng không nhớ nổi trường có bao nhiêu nhà xe và bao nhiêu căn tin nữa, chỉ biết là không phải một. \n10. Trước cổng trường là thiên đường ẩm thực, ngày nào cũng phải nghĩ nay ăn gì ta vì có nhiều sự lựa chọn quá.\nCòn thiếu gì mọi người bổ sung dưới bình luận nha\nNguồn Paul Le', 'Đã duyệt', '2024-04-23 06:35:13', '2024-05-14 04:28:04', 29),
(15, 12, NULL, 'Học kỳ hè cần học gì ạ', 'Cho em hỏi học kì hè mình có nên học mấy môn chính không ạ, hay chỉ nên học môn đại cương và thể chất. Ví dụ hè năm 1 em học thể chất 1 rồi sang hè năm sau em mới học thể chất 2, hay hè em học thể chất 1 rồi vô kì 1 em học thể chất 2 luôn ạ.', 'Vi phạm tiêu chuẩn: Thông tin sai sự thật', '2024-04-25 06:41:35', '2024-04-28 09:17:39', 3),
(16, 3, NULL, 'Nên vào KTX nào?', 'Mình đang định chuyển vào KTX, nhưng không biết nên vào A hay B, mong review từ các bạn đang và đã ở KTX', 'Đã duyệt', '2024-04-25 09:41:10', '2024-05-14 04:27:23', 13),
(17, 12, NULL, '123', '123', 'Vi phạm tiêu chuẩn: Thông tin sai sự thật', '2024-04-29 08:48:51', '2024-04-29 08:48:58', 3),
(18, 7, 'KL001', 'Chia sẻ tài liệu học Pháp luật đại cương', 'Chào các bạn, gần đây mình thấy nhiều bạn đăng bài tìm tài liệu ôn thi học phần Pháp luật đại cương (PLĐC) , nên mình cũng chia sẻ đến mọi người tài liệu và sơ đồ tư duy  mà mình đã sưu tầm tổng hợp trong thời gian học và ôn thi. Các bạn có thể tham khảo, chỉ mang tính chất tham khảo thôi nha.', 'Đã duyệt', '2024-05-13 03:27:38', '2024-05-13 22:42:31', 15),
(19, 7, NULL, 'Có thể làm part-time trước khi đi học GDQS?', 'Cho em K49 hỏi ngu ngơ một tí ạ. Mới khoảng đầu thì mình học GDQP và sẽ học ở khu Hòa An một thời gian.  Em định kiếm việc part-time trước nhưng thấy vậy cũng không biết kiếm việc có nên không ? Theo anh chị thì khoảng thời gian trước khi đi qua Hòa An thì em nên làm gì ?', 'Đã duyệt', '2024-05-13 04:33:23', '2024-05-14 11:55:16', 7),
(20, 20, NULL, 'Xin gợi ý trọ sinh viên', 'Chuyện là em định dọn ra ở trọ ý, anh chị nào biết trọ nào cho thuê dưới 1tr cho em thông tin với. \nDo em còn 1 đứa e học cao đẳng ở chung nữa nên ko thể ở ktx đx ạ :( E cám ơn ạ', 'Đã duyệt', '2024-05-14 12:22:10', '2024-05-14 12:27:59', 17),
(21, 15, NULL, 'Hỗ trợ tính tc cải thiện', 'Mọi người cho em hỏi tbtl của em là 2.22 e học 160tc hiện tại đã tích luỹ được 94tc thì cần cải thiện bao nhiêu tc để được khá ạ', 'Chưa duyệt', '2024-05-14 21:46:40', NULL, 0),
(22, 19, NULL, 'Tư vấn chọn ngành thuộc khối CNTT', 'Em có một chút năng khiếu và cũng đam mê máy tính. Em đã phân vân giữa Khoa học máy tính, Kỹ thuật phân mềm và CNTT. Anh chị tư vấn giúp em với ạ. Em cảm ơn ạ', 'Chưa duyệt', '2024-05-14 21:50:39', NULL, 0),
(23, 1, NULL, 'Chia sẻ tài liệu ôn thi TOEIC', 'Mình vừa thi TOEIC nên có thu thập 1 số tài liệu chia sẻ cho các bạn!', 'Đã duyệt', '2024-05-15 07:25:28', '2024-05-15 07:33:49', 16),
(24, 7, NULL, 'Xin tư vấn môn học kì hè', 'Cho em hỏi học kì hè mình có nên học mấy môn chính không ạ, hay chỉ nên học môn đại cương và thể chất. Ví dụ hè năm 1 em học thể chất 1 rồi sang hè năm sau em mới học thể chất 2, hay hè em học thể chất 1 rồi vô kì 1 em học thể chất 2 luôn ạ.', 'Chưa duyệt', '2024-05-15 07:36:49', NULL, 2),
(27, 7, 'ML014', 'Chia sẻ tài liệu mác triết', 'Mình có thu thập một số câu hỏi mác triết để mọi người tham khảo trước khi thi sắp tới!\nChúc các bạn học tốt!', 'Vi phạm tiêu chuẩn: Spam/Quảng cáo', '2024-05-15 10:02:15', '2024-05-15 10:02:51', 5);

-- --------------------------------------------------------

--
-- Table structure for table `binhluan_baocao`
--

CREATE TABLE `binhluan_baocao` (
  `ND_MA` int(11) NOT NULL,
  `BL_MA` int(11) NOT NULL,
  `BLBC_THOIDIEM` datetime NOT NULL,
  `BLBC_NOIDUNG` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `binhluan_baocao`
--

INSERT INTO `binhluan_baocao` (`ND_MA`, `BL_MA`, `BLBC_THOIDIEM`, `BLBC_NOIDUNG`) VALUES
(1, 43, '2024-05-14 12:27:59', 'Spam/Quảng cáo'),
(1, 48, '2024-05-12 11:02:26', 'Spam/Quảng cáo'),
(2, 43, '2024-05-10 22:22:57', 'Spam/Quảng cáo'),
(4, 21, '2024-03-30 17:59:24', 'Spam/Quảng cáo'),
(4, 22, '2024-03-30 17:59:16', 'Spam/Quảng cáo'),
(7, 22, '2024-03-30 17:58:17', 'Spam/Quảng cáo'),
(8, 21, '2024-03-30 18:01:31', 'Spam/Quảng cáo'),
(8, 22, '2024-03-30 18:01:44', 'Spam/Quảng cáo');

-- --------------------------------------------------------

--
-- Table structure for table `binhluan_thich`
--

CREATE TABLE `binhluan_thich` (
  `BL_MA` int(11) NOT NULL,
  `ND_MA` int(11) NOT NULL,
  `BLT_THOIDIEM` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `binhluan_thich`
--

INSERT INTO `binhluan_thich` (`BL_MA`, `ND_MA`, `BLT_THOIDIEM`) VALUES
(1, 2, '2024-05-14 01:34:56'),
(2, 4, '2024-05-14 01:35:06'),
(2, 7, '2024-05-14 04:35:03'),
(4, 7, '2024-05-14 04:35:03'),
(5, 2, '2024-05-14 01:35:51'),
(8, 7, '2024-05-14 04:35:07'),
(9, 4, '2024-05-14 01:58:53'),
(11, 5, '2024-05-14 02:02:38'),
(14, 3, '2024-05-14 02:11:00'),
(15, 5, '2024-05-14 02:30:54'),
(15, 7, '2024-05-14 02:18:00'),
(16, 7, '2024-05-14 02:18:02'),
(17, 7, '2024-05-14 02:18:02'),
(18, 5, '2024-05-14 02:30:47'),
(18, 7, '2024-05-14 02:18:40'),
(19, 8, '2024-05-14 03:16:31'),
(54, 20, '2024-05-14 12:27:55'),
(55, 20, '2024-05-14 12:27:57'),
(56, 20, '2024-05-14 12:27:57'),
(57, 20, '2024-05-14 12:27:59'),
(62, 7, '2024-05-15 10:04:50');

-- --------------------------------------------------------

--
-- Table structure for table `binh_luan`
--

CREATE TABLE `binh_luan` (
  `BL_MA` int(11) NOT NULL,
  `BV_MA` int(11) NOT NULL,
  `ND_MA` int(11) NOT NULL,
  `BL_TRALOI_MA` int(11) DEFAULT NULL,
  `BL_NOIDUNG` text NOT NULL,
  `BL_TRANGTHAI` varchar(255) NOT NULL,
  `BL_THOIGIANTAO` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `binh_luan`
--

INSERT INTO `binh_luan` (`BL_MA`, `BV_MA`, `ND_MA`, `BL_TRALOI_MA`, `BL_NOIDUNG`, `BL_TRANGTHAI`, `BL_THOIGIANTAO`) VALUES
(1, 1, 4, NULL, 'Hôm nay tầm 2-3h 206/B1 ạ, bạn này trắng phát sáng luôn các cậu ơi. Mng cẩn thận nhé ạ !!', 'Đang hiển thị', '2024-04-01 09:35:38'),
(2, 1, 2, NULL, 'Lại là B1 đợt tui để quên kính cận ở nhà vệ sinh. Vừa ra nhớ đi vô kiếm chưa đc 5ph mất tiêu cái kính. Bữa kia thì bạn tui mất áo khoác, cũng bạn khác mất bình nước. Vừa để đó mất đó', 'Đang hiển thị', '2024-04-01 09:36:19'),
(3, 1, 2, 2, 'Lần này là vô lớp móc túi luôn b ạ :((', 'Đã xoá', '2024-04-01 09:36:40'),
(4, 1, 4, 2, 'Lần này là vô lớp móc túi luôn b ạ :((', 'Đang hiển thị', '2024-04-01 09:37:08'),
(5, 1, 4, 1, 'Balo em để kế bên em mà bạn đó mở balo và lấy bóp của em luôn ạ', 'Đang hiển thị', '2024-04-01 09:37:38'),
(6, 1, 6, NULL, 'Nó có đồng bọn không bạn? Hay chỉ đi một mình?', 'Đang hiển thị', '2024-04-01 09:46:01'),
(7, 1, 4, 6, 'Nó có đồng bọn không bạn? Hay chỉ đi một mình?', 'Đã xoá', '2024-04-01 09:46:33'),
(8, 1, 4, 6, 'Đi 1 mình ạ, cũnh có vài bạn bị giống em rồi ạ, nó lấy nhưng chừa 1 vài tờ xong để bóp dưới chân mình ấy', 'Đang hiển thị', '2024-04-01 09:58:57'),
(9, 3, 5, NULL, 'TÒA B1 Á MỌI NGƯỜI, GIỜ THẤY AI BỎ HỌC VỀ GIỮA CHỪNG TÓM LẠI ĐI', 'Đang hiển thị', '2024-04-01 10:00:39'),
(10, 3, 6, NULL, 'Sao nghe mấy nay mất tiền nhìu dị:))', 'Đang hiển thị', '2024-04-01 10:02:09'),
(11, 3, 4, NULL, 'Có tổ chức rồi đó. Chắc nghĩ tết vào sinh viên có nhiều tiền lắm :((', 'Đang hiển thị', '2024-04-01 10:04:25'),
(12, 4, 6, NULL, 'Đầu tháng thường hạn chót nộp là ngày 17-19\nThi thì 21-25', 'Đang hiển thị', '2024-04-02 10:10:30'),
(13, 4, 3, 12, 'Mình thấy cái lịch nó để tới ngày 24 mới hết đk, mà kh bt giờ còn nhận hồ sơ kh nữa', 'Đang hiển thị', '2024-04-02 10:10:49'),
(14, 4, 5, NULL, 'Thi ở bên đường Nguyễn Văn Linh, trường chỉ đk thôi', 'Đang hiển thị', '2024-04-02 10:12:44'),
(15, 5, 5, NULL, '1. Nên học B1 vì B1 dễ xin việc làm hơn.\n2. Mình nộp lúc còn hạn, đến khi TN bằng có hết hạn cũng không ảnh hưởng.', 'Đang hiển thị', '2024-04-03 10:18:26'),
(16, 5, 4, NULL, '1. B1 thi 4 kỹ năng còn Toiec thì 2, thích cái nào hơn thì tùy mỗi người á\n2. Bạn thi xong thì có thể nộp bằng ngay cho trường để miễn Avcb và sẽ đủ đk tốt nghiệp, không cần thi lại. Còn nếu ra đi làm thì phải thi lại nhen', 'Đang hiển thị', '2024-04-03 10:19:25'),
(17, 5, 4, 16, '1. Nhưng rcm học B1 nhe, hên hên thì đậu luôn B2 :3', 'Đang hiển thị', '2024-04-03 10:19:50'),
(18, 5, 3, NULL, 'B1 hay TOEIC nó tùy vào mục đích sử dụng bằng của em nè. Ví dụ chỉ cần bằng tốt nghiệp thì học B1 dễ hơn. Còn cần bằng xin việc thì em cân nhắc ngành mình làm hợp với bằng nào á, TOEIC nó ưu tiên bên khối kinh tế, ngân hàng, CNTT, kỹ thuật đồ á', 'Đang hiển thị', '2024-04-03 10:20:25'),
(19, 8, 2, NULL, 'Bạn tham khảo', 'Đang hiển thị', '2024-04-07 11:18:11'),
(20, 8, 8, 19, 'Dạ em cảm ơn ạ', 'Đang hiển thị', '2024-04-07 11:18:38'),
(21, 9, 10, NULL, 'TUYỂN NHÂN VIÊN TRỰC PAGE-CHỐT ĐƠN ĐI LÀM NGAY \n\nThời gian làm việc:\nCa sáng: 10h30 - 13h30\nCa chiều : 14h-17h30\nCa tối: 18h-22h30\nFulltime : 10h30 - 22h30\nTHU NHẬP MỖI CA:\n- Parttime: 4 tr\n- Fulltime: 8 tr\n* Yêu cầu : Nam nữ trên 19 tuổi , không yêu cầu ngoại hình, chăm chỉ, trung thực\n+ Không có kinh nghiệm sẽ được đào tạo\n+ Có thiết bị di động + banking online để nhận lương\nINBOX NGAY ĐỂ NHẬN CÔNG VIỆC', 'Đang hiển thị', '2024-04-09 11:26:27'),
(22, 8, 10, NULL, 'QCTUYỂN NHÂN VIÊN TRỰC PAGE-CHỐT ĐƠN ĐI LÀM NGAY\n\nThời gian làm việc:\nCa sáng: 10h30 - 13h30\nCa chiều : 14h-17h30\nCa tối: 18h-22h30\nFulltime : 10h30 - 22h30\nTHU NHẬP MỖI CA:\n- Parttime: 4 tr\n- Fulltime: 8 tr\n* Yêu cầu : Nam nữ trên 19 tuổi , không yêu cầu ngoại hình, chăm chỉ, trung thực\n+ Không có kinh nghiệm sẽ được đào tạo\n+ Có thiết bị di động + banking online để nhận lương\nINBOX NGAY ĐỂ NHẬN CÔNG VIỆC', 'Đang hiển thị', '2024-04-10 11:30:45'),
(23, 10, 7, NULL, 'Đem theo tiền mặt, ít thoy, có hết thì liên hệ bà căn tin chứ dưới hk có cây ATM đâu. Có yếu bóng día vs sợ ma thì đem theo tỏi vs con dao để đầu giường, đồ ăn vặt...., bành bạc, loto....đem theo mềm vs gối ngủ.', 'Đang hiển thị', '2024-04-13 11:38:08'),
(24, 10, 8, 23, 'Còn gì nữa không chị ơi?', 'Đang hiển thị', '2024-04-14 11:39:03'),
(25, 10, 7, 24, 'Tối là phải kiếm nhóm hoặc một bn để đi chơi, k đc ở phòng nhiều về sẽ tiếc đó. Với mua nhiều thuốc uống vào sốt ho sổ mũi nhức đầu đau dạ dày gì đó, yên tâm đi kiểu gì cũng sài hết trc khi về à. Với biết cách sh tập thể thì phòng sẽ vui hơn là tự cô lập mình, book trc 7 bn đi vô là phóng vô chọn liền cho gọn đỡ vụ random, đc đi ngay suất đầu thì càng nên làm', 'Đang hiển thị', '2024-04-16 11:39:11'),
(26, 10, 5, NULL, 'Coi danh sách đại đội tìm ng ở chung trước đi bạn, chứ xuống dưới lỡ mà hong hợp thì hết dui. Nhóm tụi mình chơi chung lúc đi HA tới giờ luôn.\nĐem theo xịt muỗi, nhang muỗi, đồ cá nhân, nhớ đem giày nha( đôi nào thoải mái á). Đồ dùng cá nhân này kia. Còn tiền mặt đem dư ít có mua đồ ăn vặt ở cantin thì có mua', 'Đang hiển thị', '2024-04-16 11:40:22'),
(27, 12, 11, NULL, 'Các cô gái của đội học bổng trước xuất cảnh vào tối ngày 7/1/2024', 'Đang hiển thị', '2024-04-19 12:09:52'),
(28, 11, 9, NULL, 'Anh chị ơi cho em hỏi học bóng rổ là sân \"BOBAN\" ở đâu v ạ, cái sân gì mà bí ẩn quá k biết em k thấy trên bản đồ luôn : ))))', 'Đang hiển thị', '2024-04-19 12:12:59'),
(29, 11, 1, 28, 'trước nhà thi đấu mới á bạn', 'Đang hiển thị', '2024-04-19 13:12:59'),
(30, 11, 9, 29, 'à dạ là đi từ khoa kinh tế chạy thẳng xuống cuối đường, có cái sân mấy trụ bóng rổ kế nhà xe phải k ạ', 'Đang hiển thị', '2024-04-20 12:14:12'),
(31, 11, 1, 30, 'đr', 'Đã xoá', '2024-04-20 12:14:26'),
(32, 11, 1, 30, 'đr', 'Đang hiển thị', '2024-04-20 12:14:56'),
(33, 11, 9, 32, 'dạ em cảm ơn', 'Đang hiển thị', '2024-04-21 12:19:03'),
(34, 10, 1, NULL, 'Kinh nghiệm là nhớ đem tiền mặt, ở dưới không cà thẻ được đâu :v', 'Đang hiển thị', '2024-04-24 15:35:23'),
(39, 14, 12, NULL, '543', 'Vi phạm tiêu chuẩn: Spam/Quảng cáo', '2024-04-29 16:42:59'),
(40, 14, 12, NULL, '4', 'Vi phạm tiêu chuẩn: Thông tin sai sự thật', '2024-04-29 16:44:14'),
(41, 14, 12, NULL, '5', 'Vi phạm tiêu chuẩn: Thông tin sai sự thật', '2024-04-29 16:44:18'),
(42, 14, 12, NULL, '6', 'Vi phạm tiêu chuẩn: Spam/Quảng cáo', '2024-04-29 16:44:23'),
(43, 16, 3, NULL, '31', 'Vi phạm tiêu chuẩn: Thông tin sai sự thật', '2024-05-12 15:55:31'),
(44, 11, 7, NULL, 'Hữu ích cho tân sinh viên quá', 'Đã xoá', '2024-05-05 14:42:55'),
(45, 11, 7, NULL, 'Bổ sung thêm sơ đồ cho bài viết nè', 'Đang hiển thị', '2024-05-06 14:44:31'),
(46, 7, 7, NULL, 'Nhà thi đấu cũ thì bạn liên hệ bảo vệ thử', 'Đang hiển thị', '2024-05-11 04:29:23'),
(47, 8, 7, NULL, 'Kiểm tra inbox bạn nha', 'Đang hiển thị', '2024-05-11 04:30:02'),
(48, 18, 7, NULL, 'Chúc mọi người học tốt', 'Đang hiển thị', '2024-05-11 04:34:39'),
(49, 16, 17, NULL, 'B đi, vui lắm :))', 'Đang hiển thị', '2024-05-12 11:42:40'),
(50, 3, 17, NULL, 'căng cực căng', 'Đang hiển thị', '2024-05-13 11:43:28'),
(51, 18, 16, NULL, 'Đang cần lắm luôn á  <3', 'Đang hiển thị', '2024-05-13 11:46:24'),
(52, 16, 18, 49, 'Đông vui, đặc biệt là khuôn viên những ngày cúp điện :v', 'Đang hiển thị', '2024-05-13 11:50:17'),
(53, 6, 20, NULL, 'Cứu tinh đây rồi <33333', 'Đang hiển thị', '2024-05-13 12:04:38'),
(54, 20, 16, NULL, 'Dưới 1tr phòng nhỏ, không nhỏ thì cũng ngập, hoặc xa. Thôi giờ mình còn 1 phòng bên NVL kế BV Đa khoa trung ương. B muốn tham khảo thì mình nhắn tin gửi thông tin nha.', 'Đang hiển thị', '2024-05-14 12:19:46'),
(55, 20, 1, NULL, 'Qua hẻm 216 Tầm Vu tìm thử đi em, bên đây nhiều trọ rẻ ko ngập nữa', 'Đang hiển thị', '2024-05-14 12:22:05'),
(56, 20, 7, NULL, 'Dưới 1tr thì ở đường NVL á, vòng vòng bên đường đó có phòng dưới 1tr', 'Đang hiển thị', '2024-05-14 12:26:40'),
(57, 20, 7, 56, '1tr thì phải nhận cái giá của 1tr :((', 'Đang hiển thị', '2024-05-14 12:27:06'),
(58, 20, 20, 55, 'Vâng em cảm ơn', 'Đang hiển thị', '2024-05-14 12:27:46'),
(59, 20, 20, 54, 'Vâng em cảm ơn', 'Đang hiển thị', '2024-05-14 12:27:52'),
(60, 20, 20, 57, 'Vâng em cảm ơn', 'Đang hiển thị', '2024-05-14 12:27:59'),
(61, 20, 7, 60, 'ok', 'Đang hiển thị', '2024-05-14 21:52:36'),
(62, 23, 15, NULL, 'Bổ sung thêm cho bài viết là mn có thể mua thêm cuốn này để ôn nè', 'Đang hiển thị', '2024-05-15 08:55:05'),
(63, 23, 20, 62, 'Cuốn này đúng không bạn https://newshop.vn/600-essential-words-for-the-toeic-kem-cd.html', 'Đang hiển thị', '2024-05-15 08:56:28'),
(64, 23, 15, 63, 'đúng rồi á', 'Đang hiển thị', '2024-05-15 08:56:48'),
(65, 23, 7, NULL, 'hay quá', 'Đang hiển thị', '2024-05-15 10:04:45');

-- --------------------------------------------------------

--
-- Table structure for table `chan`
--

CREATE TABLE `chan` (
  `ND_CHAN_MA` int(11) NOT NULL,
  `ND_BICHAN_MA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cua_bai_viet`
--

CREATE TABLE `cua_bai_viet` (
  `H_HASHTAG` varchar(20) NOT NULL,
  `BV_MA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `cua_bai_viet`
--

INSERT INTO `cua_bai_viet` (`H_HASHTAG`, `BV_MA`) VALUES
('an_chay', 2),
('b1_anh_van', 5),
('canh_bao', 1),
('canh_bao', 3),
('canh_bao', 17),
('chung_chi', 5),
('chung_chi', 23),
('ho_tro', 2),
('ho_tro', 8),
('ho_tro', 12),
('ho_tro', 15),
('ho_tro', 19),
('ho_tro', 21),
('hoc_bong', 12),
('k46', 12),
('k49', 8),
('k49', 10),
('k49', 15),
('k49', 18),
('k49', 19),
('k49', 20),
('khu_2', 11),
('ktx', 16),
('ktxA', 16),
('ktxB', 16),
('ngoai_ngu', 5),
('ngoai_ngu', 23),
('nha_thi_dau', 7),
('pass_tai_lieu', 9),
('review', 14),
('review', 16),
('review', 22),
('share_tai_lieu', 6),
('share_tai_lieu', 18),
('share_tai_lieu', 23),
('share_tai_lieu', 27),
('tam_su', 13),
('thac_mac', 4),
('thi_lai_xe', 4),
('tim_do', 7),
('tim_tai_lieu', 8),
('tinh_nguyen', 2),
('toa_b1', 1),
('toa_b1', 2),
('toeic', 5),
('toeic', 23),
('tro', 20),
('tsv', 15),
('tu_van', 5),
('tu_van', 10),
('tu_van', 15),
('tu_van', 16),
('tu_van', 20),
('tu_van', 21),
('tu_van', 22),
('tu_van', 24);

-- --------------------------------------------------------

--
-- Table structure for table `danh_dau`
--

CREATE TABLE `danh_dau` (
  `ND_MA` int(11) NOT NULL,
  `BV_MA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `danh_dau`
--

INSERT INTO `danh_dau` (`ND_MA`, `BV_MA`) VALUES
(1, 2),
(1, 11),
(1, 14),
(7, 8),
(7, 10),
(7, 12),
(7, 23),
(9, 2),
(9, 4),
(9, 6),
(9, 11),
(9, 12),
(15, 23);

-- --------------------------------------------------------

--
-- Table structure for table `danh_dau_boi`
--

CREATE TABLE `danh_dau_boi` (
  `BL_MA` int(11) NOT NULL,
  `ND_MA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `danh_dau_boi`
--

INSERT INTO `danh_dau_boi` (`BL_MA`, `ND_MA`) VALUES
(19, 1),
(19, 7),
(19, 9),
(23, 7),
(26, 7);

-- --------------------------------------------------------

--
-- Table structure for table `danh_dau_file`
--

CREATE TABLE `danh_dau_file` (
  `FDK_MA` char(20) NOT NULL,
  `ND_MA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_dinh_kem`
--

CREATE TABLE `file_dinh_kem` (
  `FDK_MA` char(20) NOT NULL,
  `BV_MA` int(11) DEFAULT NULL,
  `BL_MA` int(11) DEFAULT NULL,
  `ND_GUI_MA` int(11) DEFAULT NULL,
  `ND_NHAN_MA` int(11) DEFAULT NULL,
  `TN_THOIGIANGUI` datetime DEFAULT NULL,
  `FDK_TEN` varchar(150) NOT NULL,
  `FDK_DUONGDAN` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hashtag`
--

CREATE TABLE `hashtag` (
  `H_HASHTAG` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `hashtag`
--

INSERT INTO `hashtag` (`H_HASHTAG`) VALUES
('an_chay'),
('b1_anh_van'),
('canh_bao'),
('chung_chi'),
('ho_tro'),
('hoc_bong'),
('k46'),
('k47'),
('k48'),
('k49'),
('khu_2'),
('ktx'),
('ktxA'),
('ktxB'),
('ngoai_ngu'),
('nha_thi_dau'),
('pass_tai_lieu'),
('review'),
('share_tai_lieu'),
('tam_su'),
('thac_mac'),
('thi_lai_xe'),
('tim_do'),
('tim_tai_lieu'),
('tinh_nguyen'),
('toa_b1'),
('toeic'),
('tro'),
('tsv'),
('tu_van');

-- --------------------------------------------------------

--
-- Table structure for table `hoc_phan`
--

CREATE TABLE `hoc_phan` (
  `HP_MA` char(5) NOT NULL,
  `KT_MA` char(3) NOT NULL,
  `HP_TEN` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `hoc_phan`
--

INSERT INTO `hoc_phan` (`HP_MA`, `KT_MA`, `HP_TEN`) VALUES
('CT100', 'DI', 'Kỹ năng học đại học'),
('CT101', 'DI', 'Lập trình căn bản A'),
('CT172', 'DI', 'Toán rời rạc'),
('CT174', 'DI', 'Phân tích và thiết kế thuật toán'),
('CT175', 'DI', 'Lý thuyết đồ thị'),
('CT177', 'DI', 'Cấu trúc dữ liệu'),
('CT200', 'DI', 'Nền tảng công nghệ thông tin'),
('CT273', 'DI', 'Giao diện người - máy'),
('KL001', 'KL', 'Pháp luật đại cương'),
('KL369', 'KL', 'Luật kinh tế'),
('ML014', 'MT', 'Triết học Mác - Lênin'),
('ML016', 'MT', 'Kinh tế chính trị Mác - Lênin'),
('ML018', 'MT', 'Chủ nghĩa xã hội khoa học'),
('ML019', 'MT', 'Lịch sử Đảng Cộng sản Việt Nam'),
('ML021', 'MT', 'Tư tưởng Hồ Chí Minh'),
('QP010', 'QP', 'Giáo dục quốc phòng và An ninh 1'),
('QP011', 'QP', 'Giáo dục quốc phòng và An ninh 2'),
('QP012', 'QP', 'Giáo dục quốc phòng và An ninh 3'),
('QP013', 'QP', 'Giáo dục quốc phòng và An ninh 4'),
('TC005', 'TC', 'Bóng chuyền 1'),
('TC006', 'TC', 'Bóng chuyền 2'),
('TC020', 'TC', 'Bóng chuyền 3'),
('TC025', 'TC', 'Cờ vua 1'),
('TC026', 'TC', 'Cờ vua 2'),
('TC027', 'TC', 'Cờ vua 3'),
('TN001', 'KH', 'Vi - Tích phân A1'),
('TN002', 'KH', 'Vi - Tích phân A2'),
('TN012', 'KH', 'Đại số tuyến tính và hình học'),
('TN013', 'KH', 'Đại số tuyến tính'),
('TN033', 'DI', 'Tin học căn bản'),
('TN034', 'DI', 'Thực hành Tin học căn bản'),
('TN099', 'KH', 'Vi - Tích phân'),
('XH023', 'K1', 'Anh văn căn bản 1'),
('XH024', 'K1', 'Anh văn căn bản 2'),
('XH025', 'K1', 'Anh văn căn bản 3');

-- --------------------------------------------------------

--
-- Table structure for table `khoa_truong`
--

CREATE TABLE `khoa_truong` (
  `KT_MA` char(3) NOT NULL,
  `KT_TEN` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `khoa_truong`
--

INSERT INTO `khoa_truong` (`KT_MA`, `KT_TEN`) VALUES
('CN', 'Trường Bách Khoa'),
('DB', 'Khoa Dự bị dân tộc'),
('DI', 'Trường Công nghệ Thông tin và Truyền thông.'),
('HA', 'Khoa Phát triển nông thôn'),
('K1', 'Khoa Ngoại ngữ'),
('KH', 'Khoa khoa học tự nhiên'),
('KL', 'Khoa Luật'),
('KSP', 'Khoa Sư phạm'),
('KT', 'Trường Kinh tế'),
('MT', 'Khoa khoa học chính trị'),
('MTN', 'Khoa Môi trường & Tài nguyên Thiên nhiên'),
('NN', 'Trường Nông nghiệp'),
('QP', 'Trung tâm Giáo dục Quốc phòng và An ninh'),
('TC', 'Khoa Giáo dục thể chất'),
('TS', 'Trường Thủy sản'),
('XH', ' Khoa khoa học Xã hội và Nhân văn');

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `ND_MA` int(11) NOT NULL,
  `KT_MA` char(3) DEFAULT NULL,
  `VT_MA` int(11) NOT NULL,
  `ND_HOTEN` varchar(30) NOT NULL,
  `ND_EMAIL` varchar(50) NOT NULL,
  `ND_MATKHAU` varchar(100) NOT NULL,
  `ND_MOTA` text DEFAULT NULL,
  `ND_ANHDAIDIEN` varchar(255) DEFAULT NULL,
  `ND_DIEMCONGHIEN` int(11) NOT NULL,
  `ND_TRANGTHAI` tinyint(1) NOT NULL,
  `ND_NGAYTHAMGIA` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`ND_MA`, `KT_MA`, `VT_MA`, `ND_HOTEN`, `ND_EMAIL`, `ND_MATKHAU`, `ND_MOTA`, `ND_ANHDAIDIEN`, `ND_DIEMCONGHIEN`, `ND_TRANGTHAI`, `ND_NGAYTHAMGIA`) VALUES
(1, 'DI', 1, 'Nguyễn Phương Hiếu', 'hieub2003737@student.ctu.edu.vn', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1709451758327_user1.jpg?alt=media&token=b3de5edb-d2fa-4b76-876b-3783a0da1e90', 11, 1, '2024-02-13'),
(2, 'KT', 2, 'Như Ý', 'yb2003738@student.ctu.edu.vn', '81dc9bdb52d04dc20036dbd8313ed055', 'Be Happy Be Positive', 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1709452671782_user2.jpg?alt=media&token=98ebdf2c-8cc8-47ad-92e3-2148a0b8b64a', 8, 1, '2024-03-04'),
(3, 'KH', 2, 'Nguyễn Lý Thắng', 'thangb2003739@student.ctu.edu.vn', '81dc9bdb52d04dc20036dbd8313ed055', 'Vạn sự an lành', 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1709452425068_user3.jpg?alt=media&token=6cec6d71-ad04-45ad-9a26-515d5e520b9e', 10, 1, '2024-03-10'),
(4, 'K1', 3, 'Hồng Cẩm', 'hongcam@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 19, 1, '2024-03-16'),
(5, 'K1', 3, 'Vũ Thị Thảo Duyên', 'duyenvu@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Parfois, une rencontre peut changer notre vie.', 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1709454199957_user5.jpg?alt=media&token=ac04a5ad-47bc-44d1-be2f-e1ffc69830f9', 7, 1, '2024-04-12'),
(6, NULL, 3, 'Tuấn Minh', 'tuanminh@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 3, 1, '2024-04-12'),
(7, 'DI', 3, 'Nguyễn Lam', 'lamlam@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Yêu bầu trời', 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1709457739335_user7.jpg?alt=media&token=fbd742f7-5056-4c7b-bed6-0bc6a908d6ca', 29, 1, '2024-04-13'),
(8, 'KL', 3, 'Võ Ngọc Dung', 'dungb2003740@student.ctu.edu.vn', '81dc9bdb52d04dc20036dbd8313ed055', 'Tsv CTU :3', 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1709457922871_user8.jpg?alt=media&token=46c3da21-3a49-413a-a3fb-8b97302a7179', 8, 1, '2024-04-14'),
(9, 'KSP', 3, 'Võ Minh Trí', 'minhtri@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1709459079671_user9.jpg?alt=media&token=be78e460-9ecc-4425-9a76-ccbe989d41a7', 13, 1, '2024-04-14'),
(10, NULL, 3, 'QC', 'qc@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 2, 0, '2024-04-15'),
(11, 'CN', 3, 'Lý Mỹ', 'lymy@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'Cựu sinh viên', 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1709462741760_user11.jpg?alt=media&token=18e50a6a-f368-4be0-892b-694ab10cff17', 4, 1, '2024-04-15'),
(12, NULL, 3, 'Hương Mai', 'huongmai@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1709464373535_user12.jpg?alt=media&token=86d065c8-14db-49db-adf0-d530472e9717', 7, 0, '2024-04-15'),
(13, NULL, 3, 'ABC', 'abc@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 0, 0, '2024-04-27'),
(14, NULL, 3, 'Nguyễn Phương Hiếu', 'nphieu@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 0, 1, '2024-04-29'),
(15, 'KT', 3, 'Bao Tran', 'baotran@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1714905524262_user15.jpg?alt=media&token=3942186f-35cd-47b3-adc5-82c5b539ea5d', 3, 1, '2024-04-29'),
(16, 'XH', 3, 'Ng. M. P. Uyên', 'uyen@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1714905636782_user16.jpg?alt=media&token=5ac8c2af-3d4a-4132-a83a-c479b83a13b9', 2, 1, '2024-05-06'),
(17, 'DI', 3, 'HuyHoàng', 'huyhoang@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1714905762116_user17.jpg?alt=media&token=00de4efa-49ec-4957-b759-a37a824f03fb', 2, 1, '2024-05-11'),
(18, 'DI', 3, 'Phúc Trần', 'phuc@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1714906215603_user18.jpg?alt=media&token=fe9a849e-ecde-4371-9752-ad41dce0c671', 1, 1, '2024-05-11'),
(19, 'DI', 3, 'Ng Ngọc Mỹ', 'ngmy@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 1, 1, '2024-05-13'),
(20, 'KT', 3, 'Linh Linh', 'linh2@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 'https://firebasestorage.googleapis.com/v0/b/ctu-student-community.appspot.com/o/users%2F1714907107973_user20.jpg?alt=media&token=4b275017-93d9-4167-a568-e40b9e39563a', 8, 1, '2024-05-14');

-- --------------------------------------------------------

--
-- Table structure for table `theo_doi`
--

CREATE TABLE `theo_doi` (
  `ND_THEODOI_MA` int(11) NOT NULL,
  `ND_DUOCTHEODOI_MA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `theo_doi`
--

INSERT INTO `theo_doi` (`ND_THEODOI_MA`, `ND_DUOCTHEODOI_MA`) VALUES
(3, 1),
(3, 2),
(3, 6),
(4, 1),
(4, 2),
(4, 3),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(7, 1),
(7, 3),
(7, 4),
(7, 5),
(9, 1),
(9, 2),
(9, 3),
(9, 7),
(9, 8),
(12, 1),
(12, 2),
(12, 3),
(12, 7),
(12, 11);

-- --------------------------------------------------------

--
-- Table structure for table `theo_doi_boi`
--

CREATE TABLE `theo_doi_boi` (
  `H_HASHTAG` varchar(20) NOT NULL,
  `ND_MA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `theo_doi_boi`
--

INSERT INTO `theo_doi_boi` (`H_HASHTAG`, `ND_MA`) VALUES
('an_chay', 4),
('b1_anh_van', 4),
('b1_anh_van', 5),
('canh_bao', 3),
('canh_bao', 17),
('chung_chi', 5),
('chung_chi', 16),
('ho_tro', 4),
('ho_tro', 16),
('ho_tro', 17),
('hoc_bong', 16),
('k46', 3),
('k46', 7),
('k46', 19),
('k47', 2),
('k47', 5),
('k48', 9),
('k49', 8),
('k49', 16),
('k49', 17),
('k49', 19),
('khu_2', 19),
('ktx', 19),
('ktxA', 8),
('ktxB', 3),
('ktxB', 17),
('ngoai_ngu', 5),
('pass_tai_lieu', 2),
('pass_tai_lieu', 7),
('review', 7),
('review', 17),
('review', 19),
('share_tai_lieu', 2),
('share_tai_lieu', 3),
('share_tai_lieu', 7),
('share_tai_lieu', 16),
('tam_su', 7),
('thac_mac', 2),
('thac_mac', 7),
('thi_lai_xe', 3),
('tim_do', 7),
('tim_do', 16),
('tim_tai_lieu', 7),
('tim_tai_lieu', 19),
('tinh_nguyen', 7),
('tinh_nguyen', 16),
('toeic', 5),
('toeic', 19),
('tsv', 8),
('tu_van', 3),
('tu_van', 7),
('tu_van', 9),
('tu_van', 16),
('tu_van', 17);

-- --------------------------------------------------------

--
-- Table structure for table `tin_nhan`
--

CREATE TABLE `tin_nhan` (
  `ND_GUI_MA` int(11) NOT NULL,
  `ND_NHAN_MA` int(11) NOT NULL,
  `TN_THOIGIANGUI` datetime NOT NULL,
  `TN_NOIDUNG` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vai_tro`
--

CREATE TABLE `vai_tro` (
  `VT_MA` int(11) NOT NULL,
  `VT_TEN` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Dumping data for table `vai_tro`
--

INSERT INTO `vai_tro` (`VT_MA`, `VT_TEN`) VALUES
(1, 'Quản trị viên'),
(2, 'Kiểm duyệt viên'),
(3, 'Người dùng thành viên');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baiviet_baocao`
--
ALTER TABLE `baiviet_baocao`
  ADD PRIMARY KEY (`ND_MA`,`BV_MA`),
  ADD KEY `FK_BV_BCBV` (`BV_MA`);

--
-- Indexes for table `baiviet_thich`
--
ALTER TABLE `baiviet_thich`
  ADD PRIMARY KEY (`ND_MA`,`BV_MA`),
  ADD KEY `FK_BV_TBV` (`BV_MA`);

--
-- Indexes for table `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD PRIMARY KEY (`BV_MA`),
  ADD KEY `FK_DUOC_TAO_BOI` (`ND_MA`),
  ADD KEY `FK_VE_VAN_DE` (`HP_MA`);

--
-- Indexes for table `binhluan_baocao`
--
ALTER TABLE `binhluan_baocao`
  ADD PRIMARY KEY (`ND_MA`,`BL_MA`),
  ADD KEY `FK_BL_BCBL` (`BL_MA`);

--
-- Indexes for table `binhluan_thich`
--
ALTER TABLE `binhluan_thich`
  ADD PRIMARY KEY (`BL_MA`,`ND_MA`),
  ADD KEY `FK_ND_TBL` (`ND_MA`);

--
-- Indexes for table `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD PRIMARY KEY (`BL_MA`),
  ADD KEY `FK_BINH_LUAN_BOI` (`ND_MA`),
  ADD KEY `FK_CO_BINH_LUAN` (`BV_MA`),
  ADD KEY `FK_TRA_LOI` (`BL_TRALOI_MA`);

--
-- Indexes for table `chan`
--
ALTER TABLE `chan`
  ADD PRIMARY KEY (`ND_CHAN_MA`,`ND_BICHAN_MA`),
  ADD KEY `FK_BI_CHAN` (`ND_BICHAN_MA`);

--
-- Indexes for table `cua_bai_viet`
--
ALTER TABLE `cua_bai_viet`
  ADD PRIMARY KEY (`H_HASHTAG`,`BV_MA`),
  ADD KEY `FK_CUA_BAI_VIET2` (`BV_MA`);

--
-- Indexes for table `danh_dau`
--
ALTER TABLE `danh_dau`
  ADD PRIMARY KEY (`ND_MA`,`BV_MA`),
  ADD KEY `FK_DANH_DAU2` (`BV_MA`);

--
-- Indexes for table `danh_dau_boi`
--
ALTER TABLE `danh_dau_boi`
  ADD PRIMARY KEY (`BL_MA`,`ND_MA`),
  ADD KEY `FK_DANH_DAU_BOI2` (`ND_MA`);

--
-- Indexes for table `danh_dau_file`
--
ALTER TABLE `danh_dau_file`
  ADD PRIMARY KEY (`FDK_MA`,`ND_MA`),
  ADD KEY `FK_DANH_DAU_FILE2` (`ND_MA`);

--
-- Indexes for table `file_dinh_kem`
--
ALTER TABLE `file_dinh_kem`
  ADD PRIMARY KEY (`FDK_MA`),
  ADD KEY `FK_DINH_KEM` (`BV_MA`),
  ADD KEY `FK_GAN_TRONG` (`BL_MA`),
  ADD KEY `FK_GUI_TRONG` (`ND_GUI_MA`,`ND_NHAN_MA`,`TN_THOIGIANGUI`);

--
-- Indexes for table `hashtag`
--
ALTER TABLE `hashtag`
  ADD PRIMARY KEY (`H_HASHTAG`);

--
-- Indexes for table `hoc_phan`
--
ALTER TABLE `hoc_phan`
  ADD PRIMARY KEY (`HP_MA`),
  ADD KEY `FK_DUOC_GIANG_DAY_BOI` (`KT_MA`);

--
-- Indexes for table `khoa_truong`
--
ALTER TABLE `khoa_truong`
  ADD PRIMARY KEY (`KT_MA`);

--
-- Indexes for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`ND_MA`),
  ADD KEY `FK_CO_VAI_TRO` (`VT_MA`),
  ADD KEY `FK_DANG_HOC_TAI` (`KT_MA`);

--
-- Indexes for table `theo_doi`
--
ALTER TABLE `theo_doi`
  ADD PRIMARY KEY (`ND_THEODOI_MA`,`ND_DUOCTHEODOI_MA`),
  ADD KEY `FK_DUOC_THEO_DOI` (`ND_DUOCTHEODOI_MA`);

--
-- Indexes for table `theo_doi_boi`
--
ALTER TABLE `theo_doi_boi`
  ADD PRIMARY KEY (`H_HASHTAG`,`ND_MA`),
  ADD KEY `FK_THEO_DOI_BOI2` (`ND_MA`);

--
-- Indexes for table `tin_nhan`
--
ALTER TABLE `tin_nhan`
  ADD PRIMARY KEY (`ND_GUI_MA`,`ND_NHAN_MA`,`TN_THOIGIANGUI`),
  ADD KEY `FK_NHAN_TIN_NHAN` (`ND_NHAN_MA`);

--
-- Indexes for table `vai_tro`
--
ALTER TABLE `vai_tro`
  ADD PRIMARY KEY (`VT_MA`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bai_viet`
--
ALTER TABLE `bai_viet`
  MODIFY `BV_MA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `binh_luan`
--
ALTER TABLE `binh_luan`
  MODIFY `BL_MA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `ND_MA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vai_tro`
--
ALTER TABLE `vai_tro`
  MODIFY `VT_MA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `baiviet_baocao`
--
ALTER TABLE `baiviet_baocao`
  ADD CONSTRAINT `FK_BV_BCBV` FOREIGN KEY (`BV_MA`) REFERENCES `bai_viet` (`BV_MA`),
  ADD CONSTRAINT `FK_ND_BCBV` FOREIGN KEY (`ND_MA`) REFERENCES `nguoi_dung` (`ND_MA`);

--
-- Constraints for table `baiviet_thich`
--
ALTER TABLE `baiviet_thich`
  ADD CONSTRAINT `FK_BV_TBV` FOREIGN KEY (`BV_MA`) REFERENCES `bai_viet` (`BV_MA`),
  ADD CONSTRAINT `FK_ND_TBV` FOREIGN KEY (`ND_MA`) REFERENCES `nguoi_dung` (`ND_MA`);

--
-- Constraints for table `bai_viet`
--
ALTER TABLE `bai_viet`
  ADD CONSTRAINT `FK_DUOC_TAO_BOI` FOREIGN KEY (`ND_MA`) REFERENCES `nguoi_dung` (`ND_MA`),
  ADD CONSTRAINT `FK_VE_VAN_DE` FOREIGN KEY (`HP_MA`) REFERENCES `hoc_phan` (`HP_MA`);

--
-- Constraints for table `binhluan_baocao`
--
ALTER TABLE `binhluan_baocao`
  ADD CONSTRAINT `FK_BL_BCBL` FOREIGN KEY (`BL_MA`) REFERENCES `binh_luan` (`BL_MA`),
  ADD CONSTRAINT `FK_ND_BCBL` FOREIGN KEY (`ND_MA`) REFERENCES `nguoi_dung` (`ND_MA`);

--
-- Constraints for table `binhluan_thich`
--
ALTER TABLE `binhluan_thich`
  ADD CONSTRAINT `FK_BL_TBL` FOREIGN KEY (`BL_MA`) REFERENCES `binh_luan` (`BL_MA`),
  ADD CONSTRAINT `FK_ND_TBL` FOREIGN KEY (`ND_MA`) REFERENCES `nguoi_dung` (`ND_MA`);

--
-- Constraints for table `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD CONSTRAINT `FK_BINH_LUAN_BOI` FOREIGN KEY (`ND_MA`) REFERENCES `nguoi_dung` (`ND_MA`),
  ADD CONSTRAINT `FK_CO_BINH_LUAN` FOREIGN KEY (`BV_MA`) REFERENCES `bai_viet` (`BV_MA`),
  ADD CONSTRAINT `FK_TRA_LOI` FOREIGN KEY (`BL_TRALOI_MA`) REFERENCES `binh_luan` (`BL_MA`);

--
-- Constraints for table `chan`
--
ALTER TABLE `chan`
  ADD CONSTRAINT `FK_BI_CHAN` FOREIGN KEY (`ND_BICHAN_MA`) REFERENCES `nguoi_dung` (`ND_MA`),
  ADD CONSTRAINT `FK_CHAN` FOREIGN KEY (`ND_CHAN_MA`) REFERENCES `nguoi_dung` (`ND_MA`);

--
-- Constraints for table `cua_bai_viet`
--
ALTER TABLE `cua_bai_viet`
  ADD CONSTRAINT `FK_CUA_BAI_VIET` FOREIGN KEY (`H_HASHTAG`) REFERENCES `hashtag` (`H_HASHTAG`),
  ADD CONSTRAINT `FK_CUA_BAI_VIET2` FOREIGN KEY (`BV_MA`) REFERENCES `bai_viet` (`BV_MA`);

--
-- Constraints for table `danh_dau`
--
ALTER TABLE `danh_dau`
  ADD CONSTRAINT `FK_DANH_DAU` FOREIGN KEY (`ND_MA`) REFERENCES `nguoi_dung` (`ND_MA`),
  ADD CONSTRAINT `FK_DANH_DAU2` FOREIGN KEY (`BV_MA`) REFERENCES `bai_viet` (`BV_MA`);

--
-- Constraints for table `danh_dau_boi`
--
ALTER TABLE `danh_dau_boi`
  ADD CONSTRAINT `FK_DANH_DAU_BOI` FOREIGN KEY (`BL_MA`) REFERENCES `binh_luan` (`BL_MA`),
  ADD CONSTRAINT `FK_DANH_DAU_BOI2` FOREIGN KEY (`ND_MA`) REFERENCES `nguoi_dung` (`ND_MA`);

--
-- Constraints for table `danh_dau_file`
--
ALTER TABLE `danh_dau_file`
  ADD CONSTRAINT `FK_DANH_DAU_FILE` FOREIGN KEY (`FDK_MA`) REFERENCES `file_dinh_kem` (`FDK_MA`),
  ADD CONSTRAINT `FK_DANH_DAU_FILE2` FOREIGN KEY (`ND_MA`) REFERENCES `nguoi_dung` (`ND_MA`);

--
-- Constraints for table `file_dinh_kem`
--
ALTER TABLE `file_dinh_kem`
  ADD CONSTRAINT `FK_DINH_KEM` FOREIGN KEY (`BV_MA`) REFERENCES `bai_viet` (`BV_MA`),
  ADD CONSTRAINT `FK_GAN_TRONG` FOREIGN KEY (`BL_MA`) REFERENCES `binh_luan` (`BL_MA`),
  ADD CONSTRAINT `FK_GUI_TRONG` FOREIGN KEY (`ND_GUI_MA`,`ND_NHAN_MA`,`TN_THOIGIANGUI`) REFERENCES `tin_nhan` (`ND_GUI_MA`, `ND_NHAN_MA`, `TN_THOIGIANGUI`);

--
-- Constraints for table `hoc_phan`
--
ALTER TABLE `hoc_phan`
  ADD CONSTRAINT `FK_DUOC_GIANG_DAY_BOI` FOREIGN KEY (`KT_MA`) REFERENCES `khoa_truong` (`KT_MA`);

--
-- Constraints for table `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD CONSTRAINT `FK_CO_VAI_TRO` FOREIGN KEY (`VT_MA`) REFERENCES `vai_tro` (`VT_MA`),
  ADD CONSTRAINT `FK_DANG_HOC_TAI` FOREIGN KEY (`KT_MA`) REFERENCES `khoa_truong` (`KT_MA`);

--
-- Constraints for table `theo_doi`
--
ALTER TABLE `theo_doi`
  ADD CONSTRAINT `FK_DUOC_THEO_DOI` FOREIGN KEY (`ND_DUOCTHEODOI_MA`) REFERENCES `nguoi_dung` (`ND_MA`),
  ADD CONSTRAINT `FK_THEO_DOI` FOREIGN KEY (`ND_THEODOI_MA`) REFERENCES `nguoi_dung` (`ND_MA`);

--
-- Constraints for table `theo_doi_boi`
--
ALTER TABLE `theo_doi_boi`
  ADD CONSTRAINT `FK_THEO_DOI_BOI` FOREIGN KEY (`H_HASHTAG`) REFERENCES `hashtag` (`H_HASHTAG`),
  ADD CONSTRAINT `FK_THEO_DOI_BOI2` FOREIGN KEY (`ND_MA`) REFERENCES `nguoi_dung` (`ND_MA`);

--
-- Constraints for table `tin_nhan`
--
ALTER TABLE `tin_nhan`
  ADD CONSTRAINT `FK_GUI_TIN_NHAN` FOREIGN KEY (`ND_GUI_MA`) REFERENCES `nguoi_dung` (`ND_MA`),
  ADD CONSTRAINT `FK_NHAN_TIN_NHAN` FOREIGN KEY (`ND_NHAN_MA`) REFERENCES `nguoi_dung` (`ND_MA`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
