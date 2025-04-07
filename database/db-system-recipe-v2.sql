-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2025 at 04:15 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db-system-recipe-v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `recipe_name` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `main_ingredient` varchar(50) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ingredients` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `recipe_name`, `category`, `main_ingredient`, `rating`, `image_name`, `description`, `ingredients`) VALUES
(1, 'Nasi Goreng', 'Asian', 'Nasi', 4.5, 'nasi_goreng.png', 'Panaskan sedikit minyak di wajan.\nPecahkan telur, masak sebentar, lalu aduk.\nMasukkan nasi putih dan tambahkan kecap manis.\nAduk hingga rata dan hangat.', '2 piring nasi putih (sebaiknya nasi dingin atau sisa semalam).\n2 siung bawang putih (cincang halus).\n1 butir telur.\n2 sendok makan kecap manis.\n1 sendok makan saus sambal (opsional, jika suka pedas).\nGaram dan merica secukupnya.\nMinyak untuk menumis.'),
(2, 'Spaghetti Carbonara', 'Pasta', 'Pasta', 4.3, NULL, NULL, NULL),
(3, 'Pizza Margherita', 'Italian', 'Tepung', 4.7, NULL, NULL, NULL),
(4, 'Sushi Roll', 'Japanese', 'Ikan', 4.8, NULL, NULL, NULL),
(5, 'Rendang Padang', 'Asian', 'Daging', 4.9, NULL, NULL, NULL),
(6, 'Beef Burger', 'Western', 'Daging', 4.2, NULL, NULL, NULL),
(7, 'Caesar Salad', 'Western', 'Sayur', 4.1, NULL, NULL, NULL),
(8, 'Sate Ayam', 'Asian', 'Ayam', 4.6, NULL, NULL, NULL),
(9, 'Mie Goreng Jawa', 'Asian', 'Mie', 4.4, NULL, NULL, NULL),
(10, 'Tacos Beef', 'Mexican', 'Tortilla', 4, NULL, NULL, NULL),
(11, 'Nachos Deluxe', 'Mexican', 'Tortilla', 4.3, NULL, NULL, NULL),
(12, 'Donat Gula', 'Dessert', 'Tepung', 4.2, NULL, NULL, NULL),
(13, 'Pancake Coklat', 'Dessert', 'Tepung', 4.6, NULL, NULL, NULL),
(14, 'Nasi Biryani', 'Asian', 'Nasi', 4.5, NULL, NULL, NULL),
(15, 'Lasagna Classic', 'Italian', 'Pasta', 4.4, NULL, NULL, NULL),
(16, 'Ramen Tonkotsu', 'Japanese', 'Mie', 4.7, NULL, NULL, NULL),
(17, 'Tiramisu', 'Dessert', 'Tepung', 4.8, NULL, NULL, NULL),
(18, 'Hotdog', 'Western', 'Daging', 4, NULL, NULL, NULL),
(19, 'Greek Salad', 'Chicken', 'Quinoa', 4.1, NULL, 'Cook the quinoa following the pack instructions, then rinse in cold water and drain thoroughly.\r\n\r\nMeanwhile, mix the butter, chilli and garlic into a paste. Toss the chicken fillets in 2 tsp of the olive oil with some seasoning. Lay in a hot griddle pan and cook for 3-4 mins each side or until cooked through. Transfer to a plate, dot with the spicy butter and set aside to melt.\r\n\r\nNext, tip the tomatoes, olives, onion, feta and mint into a bowl. Toss in the cooked quinoa. Stir through the remaining olive oil, lemon juice and zest, and season well. Serve with the chicken fillets on top, drizzled with any buttery chicken juices.', '225g Quinoa\n25g Butter\n1 chopped Red Chilli\n1 clove finely chopped Garlic\n400g Chicken Breast\n2 tbs Olive Oil\nHandful Black Olives\n1 chopped Red Onions\n100g  Feta\nChopped Mint\nJuice of 1/2 Lemon'),
(20, 'Chicken Curry', 'Chicken', 'chicken breast', 4.7, NULL, 'Prep:15min  ›  Cook:30min  ›  Ready in:45min \r\n\r\nFor the curry sauce: Heat oil in medium non-stick saucepan, add onion and garlic and cook until softened. Stir in carrots and cook over low heat for 10 to 12 minutes.\r\nAdd flour and curry powder; cook for 1 minute. Gradually stir in stock until combined; add honey, soy sauce and bay leaf. Slowly bring to the boil.\r\nTurn down heat and simmer for 20 minutes or until sauce thickens but is still of pouring consistency. Stir in garam masala. Pour the curry sauce through a sieve; return to saucepan and keep on low heat until ready to serve.\r\nFor the chicken: Season both sides of chicken breasts with salt and pepper. Place flour, egg and breadcrumbs in separate bowls and arrange in a row. Coat the chicken breasts in flour, then dip them into the egg, then coat in breadcrumbs, making sure you cover both sides.\r\nHeat oil in large frying pan over medium-high heat. Place chicken into hot oil and cook until golden brown, about 3 or 4 minutes each side. Once cooked, place on kitchen paper to absorb excess oil.\r\nPour curry sauce over chicken, serve with white rice and enjoy!', '4 pounded to 1cm thickness chicken breast\n2 tablespoons plain flour\n1 beaten egg\n100g fine breadcrumbs\n230ml frying vegetable oil\n2 tablespoons sunflower oil\n2 sliced onions\n5 chopped cloves garlic\n2 sliced carrot\n2 tablespoons plain flour\n4 teaspoons curry powder\n600ml chicken stock\n2 teaspoons honey\n4 teaspoons soy sauce\n1 bay leaf\n1 teaspoon garam masala'),
(21, 'Pad Thai', 'Asian', 'Mie', 4.6, NULL, NULL, NULL),
(22, 'Burrito Chicken', 'Mexican', 'Tortilla', 4.3, NULL, NULL, NULL),
(23, 'Churros', 'Dessert', 'Tepung', 4.4, NULL, NULL, NULL),
(24, 'Brownies', 'Dessert', 'Dark Chocolate', 4.5, NULL, 'Heat oven to 180C/160C fan/gas 4. Line a 20 x 30cm baking tray tin with baking parchment. Put the chocolate, butter and sugar in a pan and gently melt, stirring occasionally with a wooden spoon. Remove from the heat.\r\nStir the eggs, one by one, into the melted chocolate mixture. Sieve over the flour and cocoa, and stir in. Stir in half the raspberries, scrape into the tray, then scatter over the remaining raspberries. Bake on the middle shelf for 30 mins or, if you prefer a firmer texture, for 5 mins more. Cool before slicing into squares. Store in an airtight container for up to 3 days.', '200g Dark Chocolate\n100g  Milk Chocolate\n250g Salted Butter\n400g Light Brown Soft Sugar\n4 large Eggs\n140g Plain Flour\n50g Cocoa\n200g Raspberries'),
(25, 'Fried Rice Special', 'Asian', 'Nasi', 4.5, NULL, NULL, NULL),
(26, 'Fettuccine Alfredo', 'Pasta', 'Fettuccine', 4.4, NULL, 'Cook pasta according to package instructions in a large pot of boiling water and salt. Add heavy cream and butter to a large skillet over medium heat until the cream bubbles and the butter melts. Whisk in parmesan and add seasoning (salt and black pepper). Let the sauce thicken slightly and then add the pasta and toss until coated in sauce. Garnish with parsley, and it\'s ready.', '1 lb Fettuccine\n1/2 cup  Heavy Cream\n1/2 cup  Butter\n1/2 cup  Parmesan\n2 tbsp Parsley\nBlack Pepper'),
(27, 'Tempura Ebi', 'Japanese', 'Ikan', 4.7, NULL, NULL, NULL),
(28, 'Beef Stew', 'Western', 'Daging', 4.2, NULL, NULL, NULL),
(29, 'Veggie Salad', 'Western', 'Sayur', 4, NULL, NULL, NULL),
(30, 'Chicken Satay', 'Asian', 'Ayam', 4.9, NULL, NULL, NULL),
(31, 'Lo Mein', 'Beef', 'Beef', 4.6, NULL, 'STEP 1 - MARINATING THE BEEF\r\nIn a bowl, add the beef, salt, 1 pinch white pepper, 1 Teaspoon sesame seed oil, 1/2 egg, corn starch,1 Tablespoon of oil and mix together.\r\nSTEP 2 - BOILING THE THE NOODLES\r\nIn a 6 qt pot add your noodles to boiling water until the noodles are submerged and boil on high heat for 10 seconds. After your noodles is done boiling strain and cool with cold water.\r\nSTEP 3 - STIR FRY\r\nAdd 2 Tablespoons of oil, beef and cook on high heat untill beef is medium cooked.\r\nSet the cooked beef aside\r\nIn a wok add 2 Tablespoon of oil, onions, minced garlic, minced ginger, bean sprouts, mushrooms, peapods and 1.5 cups of water or until the vegetables are submerged in water.\r\nAdd the noodles to wok\r\nTo make the sauce, add oyster sauce, 1 pinch white pepper, 1 teaspoon sesame seed oil, sugar, and 1 Teaspoon of soy sauce.\r\nNext add the beef to wok and stir-fry', '1/2 lb Beef\npinch Salt\npinch Pepper\n2 tsp Sesame Seed Oil\n1/2  Egg\n3 tbs Starch\n5 tbs Oil\n1/4 lb Noodles\n1/2 cup  Onion\n1 tsp  Minced Garlic\n1 tsp  Ginger\n1 cup  Bean Sprouts\n1 cup  Mushrooms\n1 cup  Water\n1 tbs Oyster Sauce\n1 tsp  Sugar\n1 tsp  Soy Sauce'),
(32, 'Quesadilla', 'Mexican', 'Tortilla', 4.2, NULL, NULL, NULL),
(33, 'Cheesecake', 'Dessert', 'Butter', 4.8, NULL, 'Position an oven shelf in the middle of the oven. Preheat the oven to fan 160C/conventional 180C/gas 4. Line the base of a 23cm springform cake tin with parchment paper. For the crust, melt the butter in a medium pan. Stir in the biscuit crumbs and sugar so the mixture is evenly moistened. Press the mixture into the bottom of the pan and bake for 10 minutes. Cool on a wire rack while preparing the filling.\r\nFor the filling, increase the oven temperature to fan 200C/conventional 240C/gas 9. In a table top mixer fitted with the paddle attachment, beat the soft cheese at medium-low speed until creamy, about 2 minutes. With the mixer on low, gradually add the sugar, then the flour and a pinch of salt, scraping down the sides of the bowl and the paddle twice.\r\nSwap the paddle attachment for the whisk. Continue by adding the vanilla, lemon zest and juice. Whisk in the eggs and yolk, one at a time, scraping the bowl and whisk at least twice. Stir the 284ml carton of soured cream until smooth, then measure 200ml/7fl oz (just over 3⁄4 of the carton). Continue on low speed as you add the measured soured cream (reserve the rest). Whisk to blend, but don\'t over-beat. The batter should be smooth, light and somewhat airy.\r\nBrush the sides of the springform tin with melted butter and put on a baking sheet. Pour in the filling - if there are any lumps, sink them using a knife - the top should be as smooth as possible. Bake for 10 minutes. Reduce oven temperature to fan 90C/conventional 110C/gas 1⁄4 and bake for 25 minutes more. If you gently shake the tin, the filling should have a slight wobble. Turn off the oven and open the oven door for a cheesecake that\'s creamy in the centre, or leave it closed if you prefer a drier texture. Let cool in the oven for 2 hours. The cheesecake may get a slight crack on top as it cools.\r\nCombine the reserved soured cream with the 142ml carton, the sugar and lemon juice for the topping. Spread over the cheesecake right to the edges. Cover loosely with foil and refrigerate for at least 8 hours or overnight.\r\nRun a round-bladed knife around the sides of the tin to loosen any stuck edges. Unlock the side, slide the cheesecake off the bottom of the tin onto a plate, then slide the parchment paper out from underneath.', '85g Butter\n140g Sour Cream\n1tbsp Sugar\n900g Cream Cheese\n250g Caster Sugar\n3 tbs Plain Flour\n1 ½ teaspoons Lemon Juice\n3 Large Eggs\n250ml Sour Cream\n150ml Sour Cream\n1 tbsp Caster Sugar\n2 tsp Lemon Juice'),
(34, 'Chocolate Muffin', 'Dessert', 'Tepung', 4.7, NULL, NULL, NULL),
(35, 'Risotto', 'Seafood', 'butter', 4.3, NULL, 'Melt the butter in a thick-based pan and gently cook the onion without colour until it is soft.\r\nAdd the rice and stir to coat all the grains in the butter\r\nAdd the wine and cook gently stirring until it is absorbed\r\nGradually add the hot stock, stirring until each addition is absorbed. Keep stirring until the rice is tender\r\nSeason with the lemon juice and zest, and pepper to taste. (there will probably be sufficient saltiness from the salmon to not need to add salt) Stir gently to heat through\r\nServe scattered with the Parmesan and seasonal vegetables.\r\nGrill the salmon and gently place onto the risotto with the prawns and asparagus', '50g/2oz butter\n1 finely chopped  onion\n150g rice\n125ml  white wine\n1 litre hot vegetable stock\nThe juice and zest of one lemon\n240g large King Prawns\n150g salmon\n100g tips blanched briefly in boiling water asparagus\nground black pepper\n50g shavings Parmesan'),
(36, 'Penne Arrabiata', 'Italian', 'Pasta', 4.6, NULL, NULL, NULL),
(37, 'Sashimi Tuna', 'Japanese', 'Ikan', 4.9, NULL, NULL, NULL),
(38, 'Meatloaf', 'Miscellaneous', 'Olive Oil', 4.2, NULL, 'Heat oven to 180C/160C fan/gas 4. Heat the oil in a large frying pan and cook the onion for 8-10 mins until softened. Add the garlic, Worcestershire sauce and 2 tsp tomato purée, and stir until combined. Set aside to cool.\r\n\r\nPut the turkey mince, egg, breadcrumbs and cooled onion mix in a large bowl and season well. Mix everything to combine, then shape into a rectangular loaf and place in a large roasting tin. Spread 2 tbsp barbecue sauce over the meatloaf and bake for 30 mins.\r\n\r\nMeanwhile, drain 1 can of beans only, then pour both cans into a large bowl. Add the remaining barbecue sauce and tomato purée. Season and set aside.\r\n\r\nWhen the meatloaf has had its initial cooking time, scatter the beans around the outside and bake for 15 mins more until the meatloaf is cooked through and the beans are piping hot. Scatter over the parsley and serve the meatloaf in slices.', '1 tblsp  Olive Oil\n1 large Onion\n1 clove peeled crushed Garlic\n2 tblsp  Worcestershire Sauce\n3 tsp Tomato Puree\n500g Turkey Mince\n1 large Eggs\n85g Breadcrumbs\n2 tblsp  Barbeque Sauce\n800g Cannellini Beans\n2 tblsp  Parsley'),
(39, 'Coleslaw', 'Western', 'Sayur', 4, NULL, NULL, NULL),
(40, 'Chicken Biryani', 'Asian', 'Ayam', 4.7, NULL, NULL, NULL),
(41, 'Veggie Burrito', 'Mexican', 'Sayur', 4.2, NULL, NULL, NULL),
(42, 'Chocolate Cake', 'Vegan', 'Self-raising Flour', 4.8, NULL, 'Simply mix all dry ingredients with wet ingredients and blend altogether. Bake for 45 min on 180 degrees. Decorate with some melted vegan chocolate ', '1 1/4 cup Self-raising Flour\n1/2 cup coco sugar\n1/3 cup raw cacao\n1 tsp baking powder\n2 flax eggs\n1/2 cup almond milk\n1 tsp vanilla\n1/2 cup boiling water'),
(43, 'French Toast', 'Dessert', 'Tepung', 4.5, NULL, NULL, NULL),
(44, 'Gyoza', 'Japanese', 'Daging', 4.7, NULL, NULL, NULL),
(45, 'Peking Duck', 'Asian', 'Ayam', 4.9, NULL, NULL, NULL),
(46, 'Chicken Parmesan', 'Italian', 'Ayam', 4.8, NULL, NULL, NULL),
(47, 'Beef Wellington', 'Beef', 'mushrooms', 4.7, NULL, 'Put the mushrooms into a food processor with some seasoning and pulse to a rough paste. Scrape the paste into a pan and cook over a high heat for about 10 mins, tossing frequently, to cook out the moisture from the mushrooms. Spread out on a plate to cool.\r\nHeat in a frying pan and add a little olive oil. Season the beef and sear in the hot pan for 30 secs only on each side. (You don\'t want to cook it at this stage, just colour it). Remove the beef from the pan and leave to cool, then brush all over with the mustard.\r\nLay a sheet of cling film on a work surface and arrange the Parma ham slices on it, in slightly overlapping rows. With a palette knife, spread the mushroom paste over the ham, then place the seared beef fillet in the middle. Keeping a tight hold of the cling film from the edge, neatly roll the Parma ham and mushrooms around the beef to form a tight barrel shape. Twist the ends of the cling film to secure. Chill for 15-20 mins to allow the beef to set and keep its shape.\r\nRoll out the puff pastry on a floured surface to a large rectangle, the thickness of a £1 coin. Remove the cling film from the beef, then lay in the centre. Brush the surrounding pastry with egg yolk. Fold the ends over, the wrap the pastry around the beef, cutting off any excess. Turn over, so the seam is underneath, and place on a baking sheet. Brush over all the pastry with egg and chill for about 15 mins to let the pastry rest.\r\nHeat the oven to 200C, 400F, gas 6.\r\nLightly score the pastry at 1cm intervals and glaze again with beaten egg yolk. Bake for 20 minutes, then lower the oven setting to 180C, 350F, gas 4 and cook for another 15 mins. Allow to rest for 10-15 mins before slicing and serving with the side dishes of your choice. The beef should still be pink in the centre when you serve it.', '400g mushrooms\n1-2tbsp English Mustard\nDash Olive Oil\n750g piece Beef Fillet\n6-8 slices Parma ham\n500g Puff Pastry\nDusting Flour\n2 Beaten  Egg Yolks'),
(48, 'Clam Chowder', 'Starter', 'Clams', 4.5, NULL, 'Rinse the clams in several changes of cold water and drain well. Tip the clams into a large pan with 500ml of water. Cover, bring to the boil and simmer for 2 mins until the clams have just opened. Tip the contents of the pan into a colander over a bowl to catch the clam stock. When cool enough to handle, remove the clams from their shells – reserving a handful of empty shells for presentation if you want. Strain the clam stock into a jug, leaving any grit in the bottom of the bowl. You should have around 800ml stock.\r\nHeat the butter in the same pan and sizzle the bacon for 3-4 mins until it starts to brown. Stir in the onion, thyme and bay and cook everything gently for 10 mins until the onion is soft and golden. Scatter over the flour and stir in to make a sandy paste, cook for 2 mins more, then gradually stir in the clam stock then the milk and the cream.\r\nThrow in the potatoes, bring everything to a simmer and leave to bubble away gently for 10 mins or until the potatoes are cooked. Use a fork to crush a few of the potato chunks against the side of the pan to help thicken – you still want lots of defined chunks though. Stir through the clam meat and the few clam shells, if you\'ve gone down that route, and simmer for a minute to reheat. Season with plenty of black pepper and a little salt, if needed, then stir through the parsley just before ladling into bowls or hollowed-out crusty rolls.', '1½ kg Clams\n50g Butter\n150g Bacon\n1 finely chopped  Onion\nsprigs of fresh Thyme\n1 Bay Leaf\n1 tbls Plain Flour\n150ml Milk\n150ml Double Cream\n2 medium Potatoes\nChopped Parsley'),
(49, 'Seafood Paella', 'Spanish', 'Seafood', 4.9, NULL, NULL, NULL),
(50, 'Shrimp Tempura', 'Japanese', 'Seafood', 4.8, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
