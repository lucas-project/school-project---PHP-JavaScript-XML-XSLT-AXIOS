<?xml version="1.0" encoding="UTF-8"?>
<!--xslt file for goods.xml-->
<!--this file for displaying goods.xml's info in a table-->
<!--@author Lucas Qin, student ID is 103527269.-->
<!--@date 10/10/2022-->
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <body>
                <h2>Shopping Catalog</h2>
                <table border="1">
                    <tr bgcolor="#18dfd3">
                        <th>Item Number</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Add</th>
                    </tr>
                    <tbody id="storeItem">
                    <xsl:for-each select="items/item">
                        <xsl:choose>
                        <xsl:when test="quantity>0">
                        <xsl:variable name="itemNo" select="id"/>
                        <tr>
                            <td><xsl:value-of select="id" /></td>
                            <td><xsl:value-of select="name" /></td>
                            <td><xsl:value-of select="substring (description ,0, 20)" /></td>
                            <td><xsl:value-of select="price" /></td>
                            <td><xsl:value-of select="quantity" /></td>
                            <td><button onclick="addItemToCart({$itemNo});">Add one to cart</button></td>
                        </tr>
                        </xsl:when>
                        </xsl:choose>
                    </xsl:for-each>
                    </tbody>
                </table>
                <br/>
                <br/>
<!--                <h2>Shopping Cart</h2>-->
<!--                <table border="1">-->
<!--                    <tr bgcolor="#18dfd3">-->
<!--                        <th>Item Number</th>-->
<!--                        <th>Price</th>-->
<!--                        <th>Quantity</th>-->
<!--                        <th>Remove</th>-->
<!--                    </tr>-->
<!--                    <xsl:for-each select="items/item">-->
<!--                        <tr>-->
<!--                            <td><xsl:value-of select="id" /></td>-->
<!--                            <td><xsl:value-of select="price" /></td>-->
<!--                            <td><xsl:value-of select="quantity" /></td>-->
<!--                            <td><xsl:value-of select="add" /><button>Remove from cart</button></td>-->
<!--                        </tr>-->
<!--                    </xsl:for-each>-->
<!--                    <tr><td>Total:</td><td id="total"></td></tr>-->
<!--                    <tr><td><button>Confirm Purchase</button></td><td><button>Cancel Purchase</button></td></tr>-->
<!--                </table>-->
                <script type="text/javascript" src="buying.js">&#160;</script>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>

